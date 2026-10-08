<?php
// Important decision: every validation error is collected instead of stopping at the first error.
function validateProfile($profile) {
    $errors = [];

    if (!isset($profile["name"]) || trim($profile["name"]) === "" || strlen(trim($profile["name"])) < 3)
        $errors[] = "Name is required and must contain at least 3 characters.";

    if (!isset($profile["age"]) || !is_numeric($profile["age"]) || $profile["age"] < 0 || $profile["age"] > 120)
        $errors[] = "Age must be between 0 and 120.";

    if (!isset($profile["dzongkhag"]) || trim($profile["dzongkhag"]) === "")
        $errors[] = "Dzongkhag is required.";

    if (!isset($profile["cid"]) || strlen($profile["cid"]) !== 11)
        $errors[] = "CID must contain exactly 11 characters.";

    if (!isset($profile["status"]) || !in_array($profile["status"], ["Active", "Inactive"], true))
        $errors[] = "Status must be Active or Inactive.";

    return ["isValid" => empty($errors), "errors" => $errors];
}

$profiles = [
    ["name"=>"Pema Dorji","age"=>24,"dzongkhag"=>"Thimphu","cid"=>"12345678901","status"=>"Active"],
    ["name"=>"A","age"=>130,"dzongkhag"=>"","cid"=>"123","status"=>"Unknown"],
    ["name"=>"","age"=>-2,"dzongkhag"=>"Paro","cid"=>"1234567890","status"=>"Active"]
];
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 6</title></head>
<body>
<h1>Profile Validation Engine</h1>
<?php foreach ($profiles as $number => $profile): $result = validateProfile($profile); ?>
<h2>Profile <?= $number + 1 ?></h2>
<?php if ($result["isValid"]): ?>
<p style="color:green;"><strong>Profile is valid.</strong></p>
<?php else: ?>
<ul style="color:red;">
<?php foreach ($result["errors"] as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?>
</ul>
<?php endif; ?>
<?php endforeach; ?>
</body>
</html>
