<?php
session_start();

if (!isset($_SESSION['name'])) {
    echo json_encode(array('status' => 'error', 'message' => 'Debe iniciar sesión para donar.'));
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $conn->real_escape_string($_SESSION['name']);
$amount = (int)$_POST['amount'];
$payment_method = $conn->real_escape_string($_POST['payment-method']);

$sql = "INSERT INTO donacion (usuario, Cantidad, MetodoPago) VALUES ('$user', $amount, '$payment_method') 
        ON DUPLICATE KEY UPDATE Cantidad = Cantidad + VALUES(Cantidad)";

if ($conn->query($sql) === TRUE) {
    $result = $conn->query("SELECT SUM(Cantidad) AS total FROM donacion");
    $row = $result->fetch_assoc();
    $total = $row['total'];

    $response = array('status' => 'success', 'username' => $user, 'amount' => $amount, 'total' => $total);
    echo json_encode($response);
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Error: ' . $sql . '<br>' . $conn->error));
}

$conn->close();
?>
