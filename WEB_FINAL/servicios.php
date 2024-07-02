<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CROWFUNDING</title>
    <link rel="icon" href="images/Sin título-2.png">
    <link rel="stylesheet" href="style-servicios.css">
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

    <!-- Sección del Grid con las imágenes -->
    <div class="grid-container">
        <div class="grid-item">
            <img src="images/ayuda.png" alt="Vecindario Pacífico">
            <p>Ayuda psicológica y moral...</p>
        </div>
        <div class="grid-item">
            <img src="images/equipo.png" alt="Equipo Profesional">
            <p>Nuestro equipo profesional está dedicado a mediar y resolver conflictos para garantizar un entorno seguro y justo para todos.</p>
        </div>
        <div class="grid-item">
            <img src="images/mediador.png" alt="Mediador Profesional">
            <p>Contamos con mediadores profesionales que facilitan el diálogo y encuentran soluciones equitativas para todas las partes involucradas.</p>
        </div>
        <div class="grid-item">
            <img src="images/negocio.png" alt="Negociación Exitosa">
            <p>Nuestro objetivo es lograr negociaciones exitosas que permitan la recuperación y reconstrucción de comunidades afectadas por la ocupación ilegal.</p>
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
