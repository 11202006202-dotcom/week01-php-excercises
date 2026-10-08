<?php
// Important decision: validation and statistics are handled by reusable functions.
$profiles = [
    ["name"=>"Pema Dorji","dzongkhag"=>"Thimphu","age"=>24,"status"=>"Active","role"=>"Viewer"],
    ["name"=>"Karma Wangchuk","dzongkhag"=>"Paro","age"=>61,"status"=>"Active","role"=>"Data Officer"],
    ["name"=>"Sonam Tashi","dzongkhag"=>"Thimphu","age"=>45,"status"=>"Inactive","role"=>"Viewer"],
    ["name"=>"Dechen Choden","dzongkhag"=>"Punakha","age"=>67,"status"=>"Active","role"=>"Administrator"],
    ["name"=>"Ugyen Dorji","dzongkhag"=>"Paro","age"=>30,"status"=>"Active","role"=>"Data Officer"],
    ["name"=>"","dzongkhag"=>"Thimphu","age"=>18,"status"=>"Active","role"=>"Viewer"],
    ["name"=>"Tashi Pema","dzongkhag"=>"Haa","age"=>-5,"status"=>"Active","role"=>"Viewer"],
    ["name"=>"Choden Lhamo","dzongkhag"=>"","age"=>52,"status"=>"Unknown","role"=>"Viewer"]
];

$permissions = [
    "administrator"=>["create","read","update","delete","export"],
    "data officer"=>["create","read","update"],
    "viewer"=>["read"]
];

function validateDashboardProfile($p) {
    $errors = [];
    if (!isset($p["name"]) || trim($p["name"]) === "") $errors[] = "Missing name";
    if (!isset($p["age"]) || !is_numeric($p["age"]) || $p["age"] < 0 || $p["age"] > 120) $errors[] = "Invalid age";
    if (!isset($p["dzongkhag"]) || trim($p["dzongkhag"]) === "") $errors[] = "Missing dzongkhag";
    if (!isset($p["status"]) || !in_array($p["status"], ["Active","Inactive"], true)) $errors[] = "Invalid status";
    return $errors;
}
function countStatusSimple($profiles, $status) {
    $count=0; foreach($profiles as $p) if(($p["status"] ?? "") === $status) $count++; return $count;
}
function filterProfiles($profiles, $dzongkhag, $status) {
    $result=[];
    foreach($profiles as $p) {
        if (($p["dzongkhag"] ?? "") === $dzongkhag && ($p["status"] ?? "") === $status) $result[]=$p;
    }
    return $result;
}
function canPerform($role, $action, $permissions) {
    $role=strtolower(trim($role)); $action=strtolower(trim($action));
    return isset($permissions[$role]) && in_array($action, $permissions[$role], true);
}

$total = count($profiles);
$active = countStatusSimple($profiles, "Active");
$inactive = countStatusSimple($profiles, "Inactive");
$validAges = array_filter($profiles, fn($p) => isset($p["age"]) && is_numeric($p["age"]) && $p["age"] >= 0 && $p["age"] <= 120);
$youngest = $oldest = null;
foreach ($validAges as $p) {
    if ($youngest === null || $p["age"] < $youngest["age"]) $youngest = $p;
    if ($oldest === null || $p["age"] > $oldest["age"]) $oldest = $p;
}
$averageAge = count($validAges) ? array_sum(array_column($validAges, "age")) / count($validAges) : 0;
$selectedDzongkhag = "Thimphu";
$selectedStatus = "Active";
$filtered = filterProfiles($profiles, $selectedDzongkhag, $selectedStatus);

$scores=[]; $imperfect=0; $mostCorrection=null; $lowestScore=101;
foreach($profiles as $i=>$p) {
    $errors=validateDashboardProfile($p);
    $score=100-25*count($errors);
    $scores[]=$score;
    if($score<100) $imperfect++;
    if($score<$lowestScore) { $lowestScore=$score; $mostCorrection=$i+1; }
}
$averageScore = array_sum($scores)/count($scores);
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 10</title></head>
<body>
<h1>B-PIS Command Dashboard</h1>
<p><strong>Total profiles:</strong> <?= $total ?></p>
<p><strong>Active:</strong> <?= $active ?> | <strong>Inactive:</strong> <?= $inactive ?></p>
<p><strong>Youngest:</strong> <?= htmlspecialchars($youngest["name"] ?? "None") ?> (<?= $youngest["age"] ?? "-" ?>)</p>
<p><strong>Oldest:</strong> <?= htmlspecialchars($oldest["name"] ?? "None") ?> (<?= $oldest["age"] ?? "-" ?>)</p>
<p><strong>Average age:</strong> <?= number_format($averageAge,2) ?></p>

<h2>Filter: <?= htmlspecialchars($selectedDzongkhag) ?> + <?= htmlspecialchars($selectedStatus) ?></h2>
<ul>
<?php if (!$filtered): ?><li>No matching profiles.</li>
<?php else: foreach($filtered as $p): ?><li><?= htmlspecialchars($p["name"]) ?> - <?= htmlspecialchars($p["dzongkhag"]) ?> - <?= $p["status"] ?></li><?php endforeach; endif; ?>
</ul>

<h2>Validation and Data Quality</h2>
<table border="1" cellpadding="6">
<tr><th>#</th><th>Name</th><th>Score</th><th>Warnings</th></tr>
<?php foreach($profiles as $i=>$p): $errors=validateDashboardProfile($p); ?>
<tr>
<td><?= $i+1 ?></td><td><?= htmlspecialchars($p["name"] ?? "") ?></td><td><?= $scores[$i] ?></td>
<td><?= $errors ? htmlspecialchars(implode(", ",$errors)) : "No warnings" ?></td>
</tr>
<?php endforeach; ?>
</table>
<p><strong>Average data-quality score:</strong> <?= number_format($averageScore,2) ?></p>
<p><strong>Imperfect profiles:</strong> <?= $imperfect ?></p>
<p><strong>Record requiring most correction:</strong> Profile <?= $mostCorrection ?></p>

<h2>Permission Check</h2>
<?php $role="Data Officer"; $action="update"; ?>
<p><?= htmlspecialchars($role) ?> requesting <strong><?= htmlspecialchars($action) ?></strong>:
<?= canPerform($role,$action,$permissions) ? "Allowed" : "Not allowed" ?></p>
</body>
</html>
