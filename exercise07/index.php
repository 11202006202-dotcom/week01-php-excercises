<?php
// Important decision: the calculation function returns all parts of the calculation.
$serviceFees = [
    "Certificate" => 100,
    "Verification" => 50,
    "Replacement" => 200,
    "Correction" => 75
];

function calculateServiceFee($service, $quantity, $serviceFees) {
    if (!isset($serviceFees[$service])) return ["error" => "Unknown service."];
    if ($quantity < 1) return ["error" => "Quantity must be at least 1."];

    $cost = $serviceFees[$service] * $quantity;
    $discount = $quantity >= 5 ? $cost * 0.10 : 0;
    $processing = 20;
    $final = $cost - $discount + $processing;

    return [
        "service"=>$service, "unitFee"=>$serviceFees[$service], "quantity"=>$quantity,
        "cost"=>$cost, "discount"=>$discount, "processing"=>$processing, "final"=>$final
    ];
}

$selectedService = "Certificate";
$quantity = 5;
$result = calculateServiceFee($selectedService, $quantity, $serviceFees);
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 7</title></head>
<body>
<h1>Service Fee Calculator</h1>
<?php if (isset($result["error"])): ?>
<p style="color:red;"><strong>Error:</strong> <?= htmlspecialchars($result["error"]) ?></p>
<?php else: ?>
<table border="1" cellpadding="6">
<tr><th>Item</th><th>Value</th></tr>
<tr><td>Service</td><td><?= htmlspecialchars($result["service"]) ?></td></tr>
<tr><td>Unit Fee</td><td>Nu. <?= number_format($result["unitFee"],2) ?></td></tr>
<tr><td>Quantity</td><td><?= $result["quantity"] ?></td></tr>
<tr><td>Cost</td><td>Nu. <?= number_format($result["cost"],2) ?></td></tr>
<tr><td>Discount</td><td>Nu. <?= number_format($result["discount"],2) ?></td></tr>
<tr><td>Processing Charge</td><td>Nu. <?= number_format($result["processing"],2) ?></td></tr>
<tr><td>Final Amount</td><td>Nu. <?= number_format($result["final"],2) ?></td></tr>
</table>
<?php endif; ?>
</body>
</html>
