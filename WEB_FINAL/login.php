<?php
session_start();
include('config.php');

// Datos de conexión a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$dbname = "register"; 

$error = "";

// Verificar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Obtener el nombre de usuario y contraseña del formulario
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Preparar consulta para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Obtener datos del usuario
        $user = $result->fetch_assoc();

        // Verificar la contraseña contra el hash almacenado
        if (password_verify($password, $user['password'])) {
            // Contraseña correcta, establecer variables de sesión y redirigir
            $_SESSION['name'] = $username;
            header("location: nosotros.php");
            exit;
        } else {
            // Contraseña incorrecta
            $error = " contraseña inválidos.";
        }
    } else {
        // Usuario no encontrado
        $error = "Usuario no encontrado.";
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <div class="container">
        <h2>Formulario de Inicio de Sesión</h2>
        <form action="login.php" method="post">
            <div>
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button id="iniciar"  type="submit">Iniciar Sesión</button>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
