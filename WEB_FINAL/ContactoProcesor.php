<?php
session_start();

// Conexión a la base de datos 
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    $_SESSION['error'] = "Error de conexión: " . $conn->connect_error;
    header("Location: contacto.php");
    exit();
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$affair = isset($_POST['affair']) ? $_POST['affair'] : ''; // Permitir campo de empresa vacío
$message = $_POST['message'];

// Validar que los campos requeridos no estén vacíos
if (empty($fullname) || empty($email) || empty($phone) || empty($message)) {
    $_SESSION['error'] = "Error: Todos los campos son obligatorios, excepto el de la empresa.";
    header("Location: contacto.php");
    exit();
}

// Insertar datos en la base de datos
$sql = "INSERT INTO contacto (nombre_completo, email, telefono, nombre_empresa, mensaje)
        VALUES ('$fullname', '$email', '$phone', '$affair', '$message')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['success'] = "Datos insertados correctamente";
} else {
    $_SESSION['error'] = "Error al insertar datos: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

header("Location: contacto.php");
exit();
?>
