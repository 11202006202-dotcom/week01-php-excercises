<?php
// Important decision: permissions are stored in an associative array, not repeated conditions.
$permissions = [
    "administrator" => ["create", "read", "update", "delete", "export"],
    "data officer" => ["create", "read", "update"],
    "viewer" => ["read"]
];

function canPerformAction($role, $action, $permissions) {
    $role = strtolower(trim($role));
    $action = strtolower(trim($action));
    return isset($permissions[$role]) && in_array($action, $permissions[$role], true);
}

$tests = [
    ["Administrator","create"], ["Administrator","delete"],
    ["Data Officer","update"], ["Data Officer","delete"],
    ["Viewer","read"], ["Viewer","delete"],
    ["Unknown","read"], ["viewer","EXPORT"]
];
?>
<!DOCTYPE html>
<html>
<head><title>Exercise 8</title></head>
<body>
<h1>Role Permission Checker</h1>
<table border="1" cellpadding="6">
<tr><th>Role</th><th>Action</th><th>Result</th></tr>
<?php foreach ($tests as $test): 
    $allowed = canPerformAction($test[0], $test[1], $permissions); ?>
<tr>
<td><?= htmlspecialchars($test[0]) ?></td>
<td><?= htmlspecialchars($test[1]) ?></td>
<td><?= $allowed ? "Allowed: the role may perform this action." : "Not allowed: the role may not perform this action." ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
