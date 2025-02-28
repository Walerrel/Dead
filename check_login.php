<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$login = $data['login'];
$password = $data['password'];

$conn = new mysqli('localhost', 'username', 'password', 'database');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE login = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $login);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row && password_verify($password, $row['password'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>