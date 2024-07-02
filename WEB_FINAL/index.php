<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CROWFUNDING</title>
    <link rel="icon" href="images/Sin título-2.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
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
    <div class="body-content">
        <div class="body-txt">
            <h1>CROWFUNDING <br> VICTIMAS OCUPACIÓN </h1>
            <p style="text-align: justify;">
                Nuestro objetivo es recaudar dinero para ayudar a las victimas de okupas en España.
                Brindarles un espacio para que puedan dormir, comida y ayudas para trámites legales.
            </p>
            <?php if(!isset($_SESSION['name'])): ?>
                <a href="register.html" class="btn">REGÍSTRATE</a>
            <?php endif; ?>
        </div>
        <div class="body.img">
            <img src="images/casa.png" alt="">
        </div>
    </div>

    <!-- Icono flotante -->
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

    <script>
        function toggleButton() {
            var navbar = document.querySelector('.navbar');

            // Cambia la visibilidad del navbar mediante la clase 'active' y ajusta la altura y opacidad
            navbar.classList.toggle('active');

            if (navbar.classList.contains('active')) {
                navbar.style.display = 'flex';
                setTimeout(function () {
                    navbar.style.opacity = '1';
                    navbar.style.height = 'auto';
                }, 10);
            } else {
                navbar.style.opacity = '0';
                navbar.style.height = '0';

                // Retrasa el cambio de visibilidad hasta que termine la animación de cierre
                setTimeout(function () {
                    navbar.style.display = 'none';
                }, 500); // Ajusta este valor según la duración de la transición
            }

            // Agrega un evento para ocultar el menú cuando el ancho de la ventana es mayor a 991px
            window.addEventListener('resize', function () {
                if (window.innerWidth > 991) {
                    navbar.style.display = 'initial';
                    navbar.style.opacity = '1';
                    navbar.style.height = 'auto';
                } else {
                    navbar.style.display = 'none';
                    navbar.style.opacity = '0';
                    navbar.style.height = '0';
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetch('getUserSession.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('User is logged in:', data.username);
                    // You can update the UI based on the session data here
                } else {
                    console.log('User not logged in:', data.message);
                    // You can update the UI to show login buttons etc.
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
