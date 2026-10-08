<?php
// Important decision: counters are created dynamically from the request list.
$requests = ["Thimphu", "Paro", "Thimphu", "Punakha", "Paro", "Thimphu"];
$counts = [];

foreach ($requests as $dzongkhag) {
    if (!isset($counts[$dzongkhag])) $counts[$dzongkhag] = 0;
    $counts[$dzongkhag]++;
}

$highest = "";
$highestCount = 0;
foreach ($counts as $dzongkhag => $count) {
    if ($count > $highestCount) {
        $highest = $dzongkhag;
        $highestCount = $count;
    }
}
$thimphuPercentage = count($requests) > 0 ? ($counts["Thimphu"] ?? 0) / count($requests) * 100 : 0;
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 4</title></head>
<body>
<h1>Dzongkhag Service Counter</h1>
<ol>
<?php foreach ($requests as $i => $request): ?>
<li>Request <?= $i + 1 ?>: <?= htmlspecialchars($request) ?></li>
<?php endforeach; ?>
</ol>
<h2>Counts</h2>
<ul>
<?php foreach ($counts as $dzongkhag => $count): ?>
<li><?= htmlspecialchars($dzongkhag) ?>: <?= $count ?></li>
<?php endforeach; ?>
</ul>
<p><strong>Highest:</strong> <?= htmlspecialchars($highest) ?> (<?= $highestCount ?> requests)</p>
<p><strong>Total requests:</strong> <?= count($requests) ?></p>
<p><strong>Thimphu percentage:</strong> <?= number_format($thimphuPercentage, 2) ?>%</p>
</body>
</html>
