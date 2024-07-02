<?php
$servername = "localhost";
$username = "root"; 
$dbname = "register";
$password = "root";

$name_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_check_email = "SELECT id FROM usuarios WHERE email = ?";
    if ($stmt_check_email = $conn->prepare($sql_check_email)) {
        $stmt_check_email->bind_param("s", $param_email_check);
        $param_email_check = $email;
        $stmt_check_email->execute();
        $stmt_check_email->store_result();

        if ($stmt_check_email->num_rows == 0) {
            $sql_check_name = "SELECT id FROM usuarios WHERE name = ?";
            if ($stmt_check_name = $conn->prepare($sql_check_name)) {
                $stmt_check_name->bind_param("s", $param_name_check);
                $param_name_check = $name;
                $stmt_check_name->execute();
                $stmt_check_name->store_result();

                if ($stmt_check_name->num_rows == 0) {
                    $stmt_check_name->close();

                    $sql_insert = "INSERT INTO usuarios (name, email, password) VALUES (?, ?, ?)";
                    if ($stmt = $conn->prepare($sql_insert)) {
                        $stmt->bind_param("sss", $param_name, $param_email, $param_password);
                        $param_name = $name;
                        $param_email = $email;
                        $param_password = password_hash($password, PASSWORD_DEFAULT);

                        if ($stmt->execute()) {
                            header("Location: login.html");
                            exit();
                        } else {
                            echo "ERROR: Could not execute query: $sql_insert. " . $conn->error;
                        }
                    } else {
                        echo "ERROR: Could not prepare query: $sql_insert. " . $conn->error;
                    }

                    $stmt->close();
                } else {
                    $name_err = "Name is already registered.";
                }
            } else {
                echo "ERROR: Could not prepare query: $sql_check_name. " . $conn->error;
            }
        } else {
            $email_err = "Email is already registered.";
        }
    } else {
        echo "ERROR: Could not prepare query: $sql_check_email. " . $conn->error;
    }

    $stmt_check_email->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-register.css">
    <title>Registration</title>
</head>
<body>
    <div class="container">
        <h2>Formulario de Registro</h2>
        <form id="registerForm" action="register.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <input type="hidden" id="nameErrorInput" value="<?php echo $name_err; ?>"><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <input type="hidden" id="emailErrorInput" value="<?php echo $email_err; ?>"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" id="register" value="Register">
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.html">Iniciar sesión</a></p>
    </div>
    <script>
        window.onload = function() {
            var nameErrorInput = document.getElementById('nameErrorInput').value;
            var emailErrorInput = document.getElementById('emailErrorInput').value;

            if (nameErrorInput) {
                var nameInput = document.getElementById('name');
                nameInput.setCustomValidity(nameErrorInput);
                nameInput.reportValidity();
                nameInput.addEventListener('input', function() {
                    nameInput.setCustomValidity('');
                });
            }

            if (emailErrorInput) {
                var emailInput = document.getElementById('email');
                emailInput.setCustomValidity(emailErrorInput);
                emailInput.reportValidity();
                emailInput.addEventListener('input', function() {
                    emailInput.setCustomValidity('');
                });
            }
        };
    </script>
</body>
</html>
