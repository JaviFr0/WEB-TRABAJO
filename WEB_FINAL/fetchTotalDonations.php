<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT SUM(Cantidad) AS total FROM donacion");
$row = $result->fetch_assoc();
$total = $row['total'];

$response = array('status' => 'success', 'total' => $total);
echo json_encode($response);

$conn->close();
?>
