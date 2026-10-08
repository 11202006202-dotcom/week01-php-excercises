<?php
// Important decision: stripos() makes the name search case-insensitive.
$profiles = [
    ["name"=>"Pema Dorji","dzongkhag"=>"Thimphu","age"=>24,"status"=>"Active"],
    ["name"=>"Pema Wangchuk","dzongkhag"=>"Paro","age"=>31,"status"=>"Active"],
    ["name"=>"Karma Dorji","dzongkhag"=>"Punakha","age"=>42,"status"=>"Inactive"],
    ["name"=>"Sonam Tashi","dzongkhag"=>"Thimphu","age"=>28,"status"=>"Active"],
    ["name"=>"Tashi Pema","dzongkhag"=>"Paro","age"=>36,"status"=>"Inactive"],
    ["name"=>"Dechen Choden","dzongkhag"=>"Haa","age"=>22,"status"=>"Active"],
    ["name"=>"Ugyen Dorji","dzongkhag"=>"Thimphu","age"=>55,"status"=>"Active"],
    ["name"=>"Karma Sonam","dzongkhag"=>"Punakha","age"=>19,"status"=>"Active"]
];

function searchProfiles($profiles, $term) {
    $matches = [];
    foreach ($profiles as $profile) {
        if (stripos($profile["name"], $term) !== false) $matches[] = $profile;
    }
    return $matches;
}

$searchTerm = "pema";
$results = searchProfiles($profiles, $searchTerm);
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 5</title></head>
<body>
<h1>B-PIS Record Search</h1>
<h2>All Profiles</h2>
<table border="1" cellpadding="6">
<tr><th>Name</th><th>Dzongkhag</th><th>Age</th><th>Status</th></tr>
<?php foreach ($profiles as $p): ?>
<tr><td><?= htmlspecialchars($p["name"]) ?></td><td><?= htmlspecialchars($p["dzongkhag"]) ?></td><td><?= $p["age"] ?></td><td><?= $p["status"] ?></td></tr>
<?php endforeach; ?>
</table>
<h2>Search: <?= htmlspecialchars($searchTerm) ?></h2>
<p><strong>Matches:</strong> <?= count($results) ?></p>
<?php if (empty($results)): ?>
<p>No matching records found.</p>
<?php else: ?>
<ul>
<?php foreach ($results as $p): ?><li><?= htmlspecialchars($p["name"]) ?> - <?= htmlspecialchars($p["dzongkhag"]) ?> - <?= $p["age"] ?> - <?= $p["status"] ?></li><?php endforeach; ?>
</ul>
<?php endif; ?>
</body>
</html>
