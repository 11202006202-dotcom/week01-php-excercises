<?php
// Important decision: classification is kept in one reusable function.
function classifyAge($age) {
    if ($age < 0 || $age > 120) {
        return [
            "ageGroup" => "Invalid",
            "eligible" => false,
            "explanation" => "Age must be between 0 and 120."
        ];
    }

    if ($age < 13) {
        return ["ageGroup" => "Child", "eligible" => false,
                "explanation" => "The citizen is under 18, so the adult-only service is not available."];
    } elseif ($age <= 17) {
        return ["ageGroup" => "Teenager", "eligible" => false,
                "explanation" => "The citizen is under 18, so the adult-only service is not available."];
    } elseif ($age <= 59) {
        return ["ageGroup" => "Adult", "eligible" => true,
                "explanation" => "The citizen is an adult and qualifies for the adult-only service."];
    } else {
        return ["ageGroup" => "Senior Citizen", "eligible" => true,
                "explanation" => "The citizen is 60 or older and qualifies for the adult-only service."];
    }
}

$citizenName = "Pema Dorji";
$age = 24;
$result = classifyAge($age);
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 2</title></head>
<body>
<h1>Age and Service Eligibility</h1>
<p><strong>Name:</strong> <?= htmlspecialchars($citizenName) ?></p>
<p><strong>Age:</strong> <?= $age ?></p>
<p><strong>Age Group:</strong> <?= $result["ageGroup"] ?></p>
<p><strong>Adult-only Service:</strong> <?= $result["eligible"] ? "Eligible" : "Not Eligible" ?></p>
<p><strong>Explanation:</strong> <?= htmlspecialchars($result["explanation"]) ?></p>
<h2>Test Cases</h2>
<ul>
<?php foreach ([8, 15, 18, 59, 60, 130] as $testAge): $r = classifyAge($testAge); ?>
<li><?= $testAge ?> years: <?= htmlspecialchars($r["ageGroup"]) ?> - <?= htmlspecialchars($r["explanation"]) ?></li>
<?php endforeach; ?>
</ul>
</body>
</html>
