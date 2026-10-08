<?php
// Important decision: separate functions make each report calculation easy to reuse.
$records = [
    ["name"=>"Pema Dorji","dzongkhag"=>"Thimphu","age"=>24,"status"=>"Active","type"=>"Citizen"],
    ["name"=>"Karma Wangchuk","dzongkhag"=>"Paro","age"=>61,"status"=>"Active","type"=>"Citizen"],
    ["name"=>"Sonam Tashi","dzongkhag"=>"Thimphu","age"=>45,"status"=>"Inactive","type"=>"Service"],
    ["name"=>"Dechen Choden","dzongkhag"=>"Punakha","age"=>67,"status"=>"Active","type"=>"Citizen"],
    ["name"=>"Ugyen Dorji","dzongkhag"=>"Paro","age"=>30,"status"=>"Active","type"=>"Service"],
    ["name"=>"Tashi Pema","dzongkhag"=>"Thimphu","age"=>18,"status"=>"Inactive","type"=>"Citizen"],
    ["name"=>"Choden Lhamo","dzongkhag"=>"Haa","age"=>52,"status"=>"Active","type"=>"Service"],
    ["name"=>"Jigme Wangdi","dzongkhag"=>"Punakha","age"=>72,"status"=>"Active","type"=>"Citizen"],
    ["name"=>"Kelsang Dorji","dzongkhag"=>"Thimphu","age"=>33,"status"=>"Active","type"=>"Citizen"],
    ["name"=>"Yangchen Pema","dzongkhag"=>"Haa","age"=>63,"status"=>"Inactive","type"=>"Service"]
];

function countByField($records, $field) {
    $counts = [];
    foreach ($records as $record) {
        $value = $record[$field];
        if (!isset($counts[$value])) $counts[$value] = 0;
        $counts[$value]++;
    }
    return $counts;
}
function countStatus($records) { return countByField($records, "status"); }
function countDzongkhag($records) { return countByField($records, "dzongkhag"); }
function countRecordType($records) { return countByField($records, "type"); }
function activePercentage($records) {
    $active = 0;
    foreach ($records as $record) if ($record["status"] === "Active") $active++;
    return count($records) ? $active / count($records) * 100 : 0;
}
$statuses = countStatus($records);
$dzongkhags = countDzongkhag($records);
$types = countRecordType($records);
$adults = $seniors = 0;
foreach ($records as $r) {
    if ($r["age"] >= 18 && $r["age"] <= 59) $adults++;
    if ($r["age"] >= 60) $seniors++;
}
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 9</title></head>
<body>
<h1>B-PIS Records Report</h1>
<p><strong>Total records:</strong> <?= count($records) ?></p>
<p><strong>Active:</strong> <?= $statuses["Active"] ?? 0 ?> | <strong>Inactive:</strong> <?= $statuses["Inactive"] ?? 0 ?></p>
<p><strong>Adults:</strong> <?= $adults ?> | <strong>Senior Citizens:</strong> <?= $seniors ?></p>
<p><strong>Active percentage:</strong> <?= number_format(activePercentage($records),2) ?>%</p>

<h2>Records</h2>
<table border="1" cellpadding="6">
<tr><th>Name</th><th>Dzongkhag</th><th>Age</th><th>Status</th><th>Type</th></tr>
<?php foreach ($records as $r): ?>
<tr><td><?= htmlspecialchars($r["name"]) ?></td><td><?= htmlspecialchars($r["dzongkhag"]) ?></td><td><?= $r["age"] ?></td><td><?= $r["status"] ?></td><td><?= $r["type"] ?></td></tr>
<?php endforeach; ?>
</table>

<h2>Dzongkhag Counts</h2><ul>
<?php foreach ($dzongkhags as $d=>$c): ?><li><?= htmlspecialchars($d) ?>: <?= $c ?></li><?php endforeach; ?>
</ul>
<h2>Record Type Counts</h2><ul>
<?php foreach ($types as $t=>$c): ?><li><?= htmlspecialchars($t) ?>: <?= $c ?></li><?php endforeach; ?>
</ul>
</body>
</html>
