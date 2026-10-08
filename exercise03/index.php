<?php
// Important decision: loops are used so the program works with any number of names.
$members = ["Pema", "Karma", "Sonam", "Tashi", "Dechen", "Ugyen"];

function memberSummary($members) {
    $shortest = $members[0];
    $longest = $members[0];
    $totalLength = 0;

    foreach ($members as $name) {
        $length = strlen($name);
        $totalLength += $length;
        if ($length < strlen($shortest)) $shortest = $name;
        if ($length > strlen($longest)) $longest = $name;
    }

    return [
        "count" => count($members),
        "shortest" => $shortest,
        "longest" => $longest,
        "average" => $totalLength / count($members)
    ];
}
$summary = memberSummary($members);
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 3</title></head>
<body>
<h1>Household Member Summary</h1>
<ol>
<?php foreach ($members as $name): ?>
<li><?= htmlspecialchars($name) ?> (<?= strlen($name) ?> characters)</li>
<?php endforeach; ?>
</ol>
<p><strong>Total:</strong> <?= $summary["count"] ?></p>
<p><strong>First:</strong> <?= htmlspecialchars($members[0]) ?></p>
<p><strong>Last:</strong> <?= htmlspecialchars($members[count($members)-1]) ?></p>
<p><strong>Shortest:</strong> <?= htmlspecialchars($summary["shortest"]) ?></p>
<p><strong>Longest:</strong> <?= htmlspecialchars($summary["longest"]) ?></p>
<p><strong>Average name length:</strong> <?= number_format($summary["average"], 2) ?></p>
</body>
</html>
