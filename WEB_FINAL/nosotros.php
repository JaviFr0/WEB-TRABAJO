<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.html");
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

$result = $conn->query("SELECT usuario, SUM(Cantidad) AS total_amount FROM donacion GROUP BY usuario");
$donations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['total_amount'] > 0) {
            $donations[] = $row;
        }
    }
}

$conn->close();

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CROWDFUNDING - Ayuda a Víctimas de Ocupación</title>
    <link rel="icon" href="images/Sin título-2.png">
    <link rel="stylesheet" href="Style_nosotros.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
        .progress-container {
            width: 80%;
            background-color: #e0e0e0;
            border-radius: 25px;
            margin: 10px auto;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10px;
        }

        .progress-bar {
            height: 20px;
            background-color: #4caf50;
            text-align: center;
            line-height: 20px;
            color: white;
            border-radius: 25px;
            font-size: 12px;
            transition: width 0.5s;
        }

        #goal-amount {
            font-size: 14px;
            color: #000;
            margin-left: 10px;
        }

        .donations-table {
            width: 40%;
            border-collapse: collapse;
            margin: 10px auto;
            background-color: transparent;
        }

        .donations-table th,
        .donations-table td {
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px;
            text-align: center;
            color: white;
        }

        .donations-table th {
            background-color: rgba(76, 175, 80, 0.8);
            color: white;
        }

        .donations-table td {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            display: inline-block;
            padding: 13px 30px;
            background: linear-gradient(90deg, #ac96a3 0%, #c1afba 100%);
            color: #fff;
            font-size: 18px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            margin: 10px auto;
            text-align: center;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="menu">
            <img src="images/Sin título-2.png" class="logo">
            <button id="menu-toggle" onclick="toggleButton()">
                <div></div>
                <div></div>
                <div></div>
            </button>
            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="Servicios.php">Servicios</a></li>
                    <li><a href="Contacto.php">Contacto</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <?php if(isset($_SESSION['name'])): ?>
                    <a href="logout.php" class="btn">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.html" class="btn">Iniciar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="header-content">
        <div class="header-txt">
            <h1>Crowdfunding<br> para Ayudar a Víctimas de Ocupación en España</h1>
            <p style="text-align: justify;">
                Somos dos estudiantes de la Universidad Europea de Madrid y estamos llevando a cabo este proyecto con la finalidad de ayudar a las víctimas de ocupación en España. Nuestro objetivo es recaudar dinero para brindarles un espacio seguro, comida y asistencia para trámites legales.
            </p>
            <div style="text-align: center;">
                <a href="#" class="btn" id="donate-button">DONACIÓN</a>
            </div>
            <div class="progress-container">
                <div class="progress-bar" id="progress-bar">0%</div>
                <span id="goal-amount">Meta: €1000</span>
            </div>
            <table class="donations-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody id="donations-table-body">
                    <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($donation['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($donation['total_amount']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="donation-modal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Formulario de Donación</h2>
                <form id="donation-form" action="donationProcessor.php" method="post">
                    <input type="hidden" id="username" name="username" value="<?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <label for="amount">Cantidad:</label>
                    <input type="number" id="amount" name="amount" required>

                    <label for="payment-method">Método de Pago:</label>
                    <select id="payment-method" name="payment-method" required>
                        <option value="tarjeta">Tarjeta de Crédito</option>
                        <option value="paypal">PayPal</option>
                    </select>

                    <button type="submit" class="btn-donate">Donar</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var userName = "<?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?>";
    if (userName) {
        document.getElementById('user-name').innerText = userName;
    }

    function toggleButton() {
        var navbar = document.querySelector('.navbar');
        navbar.classList.toggle('active');
        if (navbar.classList.contains('active')) {
            navbar.style.display = 'flex';
            setTimeout(function() {
                navbar.style.opacity = '1';
                navbar.style.height = 'auto';
            }, 10);
        } else {
            navbar.style.opacity = '0';
            navbar.style.height = '0';
            setTimeout(function() {
                navbar.style.display = 'none';
            }, 500);
        }
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                navbar.style.display = 'initial';
                navbar.style.opacity = '1';
                navbar.style.height = 'auto';
            } else if (!navbar.classList.contains('active')) {
                navbar.style.display = 'none';
                navbar.style.opacity = '0';
                navbar.style.height = '0';
            }
        });
    }

    var modal = document.getElementById("donation-modal");
    var btn = document.getElementById("donate-button");
    var span = document.getElementsByClassName("close-button")[0];

    if (btn) {
        btn.onclick = function(event) {
            event.preventDefault();
            modal.style.display = "block";
        }
    }

    if (span) {
        span.onclick = function() {
            modal.style.display = "none";
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function updateProgressBar(raisedAmount, goalAmount) {
        var progressBar = document.getElementById('progress-bar');
        var percentage = (raisedAmount / goalAmount) * 100;
        progressBar.style.width = percentage + '%';
        progressBar.innerText = Math.round(percentage) + '%';
    }

    function fetchTotalDonations() {
        fetch('fetchTotalDonations.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    var goalAmount = 1000; // Define your goal amount
                    updateProgressBar(data.total, goalAmount);
                } else {
                    console.error('Error fetching total donations:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    var donationForm = document.getElementById('donation-form');
    donationForm.addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(donationForm);

        fetch('donationProcessor.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                var tableBody = document.getElementById('donations-table-body');

                var existingRow = null;
                for (var i = 0; i < tableBody.rows.length; i++) {
                    if (tableBody.rows[i].cells[0].innerText === data.username) {
                        existingRow = tableBody.rows[i];
                        break;
                    }
                }

                if (existingRow) {
                    existingRow.cells[1].innerText = parseFloat(existingRow.cells[1].innerText) + parseFloat(data.amount);
                } else {
                    var newRow = tableBody.insertRow();
                    var usernameCell = newRow.insertCell(0);
                    var amountCell = newRow.insertCell(1);
                    usernameCell.innerText = data.username;
                    amountCell.innerText = data.amount;
                }

                var goalAmount = 1000;
                updateProgressBar(data.total, goalAmount);

                // Show success message
                var successMessage = document.createElement('div');
                successMessage.innerText = "¡Donación realizada correctamente!";
                successMessage.className = "success-message";
                document.querySelector('.header-content').appendChild(successMessage);

                setTimeout(function() {
                    successMessage.remove();
                }, 3000);

                modal.style.display = "none";
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    fetchTotalDonations();
});

    </script>

    <div class="floating-icon">
        <i class="fas fa-user"></i>
        <span>
            <?php 
                if(isset($_SESSION['name'])) { 
                    echo htmlspecialchars($_SESSION['name']); 
                } else { 
                    echo "Perfil"; 
                } 
            ?>
        </span>
    </div>
</body>

</html>
