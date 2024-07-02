<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CROWFUNDING</title>
    <link rel="icon" href="images/Sin título-2.png">
    <link rel="stylesheet" href="style-contacto.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
        .message {
            border: 1px solid;
            margin: 10px 0;
            padding: 15px 10px 15px 50px;
            background-repeat: no-repeat;
            background-position: 10px center;
            font-size: 18px;
            position: relative;
            animation: fadeOut 5s forwards;
        }
        .error-message {
            color: #D8000C;
            background-color: #FFBABA;
            background-image: url('https://i.imgur.com/GnyDvKN.png');
        }
        .success-message {
            color: #4F8A10;
            background-color: #DFF2BF;
            background-image: url('https://i.imgur.com/Q9BGTuy.png');
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                display: none;
            }
        }
    </style>
</head>

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

<body>
    <div class="content">
        <h1>CONTACTO</h1>

        <div class="contact-wrapper animated bounceInUp">
            <div class="contact-form">
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="message error-message" id="error-message">
                        <?php 
                            echo htmlspecialchars($_SESSION['error']); 
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="message success-message" id="success-message">
                        <?php 
                            echo htmlspecialchars($_SESSION['success']); 
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <form action="ContactoProcesor.php" method="POST" onsubmit="return validateForm()">
                    <p>
                        <label>Nombre Completo</label>
                        <input type="text" name="fullname" placeholder="Ingrese su nombre completo">
                    </p>
                    <p>
                        <label>Email</label>
                        <input type="email" name="email" placeholder="ejemplo@gmail.com">
                    </p>
                    <p>
                        <label>Numero de telefono</label>
                        <input type="tel" name="phone" placeholder="Ingrese su telefono">
                    </p>
                    <p>
                        <label>Nombre de la empresa</label>
                        <input type="text" name="affair" placeholder="Si no es una empresa omita este campo">
                    </p>
                    <p class="block">
                        <label>Mensaje</label>
                        <textarea name="message" rows="2" placeholder="Su mensaje"></textarea>
                    </p>
                    <p class="block">
                        <button type="submit">
                            Enviar
                        </button>
                    </p>
                </form>
            </div>
            <div class="contact-info">
                <ul>
                    <li><span class="material-symbols-outlined">apartment</span> Universidad Europea de Madrid</li>
                    <li><span class="material-symbols-outlined"> call</span> +34 628 999 999</li>
                    <li><span class="material-symbols-outlined">mail</span> crowdfunding.contra.okupas@gmail.com</li>
                </ul>
            </div>
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
</body>

</html>

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
            }, 500); // duración de la transición
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
</script>
