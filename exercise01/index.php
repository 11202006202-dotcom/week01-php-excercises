<?php
// Important decision: the CID length is checked before showing the warning.
$citizen = [
    "name" => "Karma Dorji",
    "cid" => "12345678901",
    "dob" => "2002-05-15",
    "dzongkhag" => "Thimphu",
    "gewog" => "Chang",
    "occupation" => "IT Student",
    "active" => true
];

function displayProfileField($label, $value) {
    echo "<p><strong>" . htmlspecialchars($label) . ":</strong> " .
         htmlspecialchars((string)$value) . "</p>";
}

$status = $citizen["active"] ? "Active" : "Inactive";
$cidLength = strlen($citizen["cid"]);
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 1</title></head>
<body>
<h1>Fictional Citizen Profile</h1>
<?php
displayProfileField("Full Name", strtoupper($citizen["name"]));
displayProfileField("CID", $citizen["cid"]);
displayProfileField("Date of Birth", $citizen["dob"]);
displayProfileField("Dzongkhag", $citizen["dzongkhag"]);
displayProfileField("Gewog", $citizen["gewog"]);
displayProfileField("Occupation", $citizen["occupation"]);
displayProfileField("Status", $status);
displayProfileField("CID Characters", $cidLength);

if ($cidLength !== 11) {
    echo "<p style='color:red;'><strong>Warning:</strong> CID must contain exactly 11 characters.</p>";
}
?>
</body>
</html>
