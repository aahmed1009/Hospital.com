<?php
include 'db.php'; // Make sure the path and file exist

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $value = $_POST['value'];

    if ($type == "username") {
        $checkSql = "SELECT COUNT(*) FROM users WHERE username = ?";
    } elseif ($type == "email") {
        $checkSql = "SELECT COUNT(*) FROM users WHERE email = ?";
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid type"]);
        exit;
    }

    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([$value]);
    $exists = $checkStmt->fetchColumn();

    if ($exists) {
        echo json_encode(["status" => "error", "message" => ucfirst($type) . " already exists."]);
    } else {
        echo json_encode(["status" => "success", "message" => ucfirst($type) . " is available."]);
    }
}
?>