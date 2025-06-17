<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <div class="Titulo">
    <title>Xport | <?php echo $titulo?></title>
    </div>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/miestilo.css" rel="stylesheet" >
  </head>
  <body class="bg-primary">

    <nav class="navbar navbar-expand-lg bg-secondary">
      <div class="container-fluid">
        <a class="navbar-brand" href="/proyecto_mazzanti_marcos"><img src="assets/img/logo-xport-blanco.png" class="img-logo-menu"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <?php if(session('perfil_id') == 1): ?>
          <div class="btn btn-info active btnUser btn-sm">
            <a href="">USUARIO: <?php echo session('nombre'); ?></a>
          </div>
        <?php endif; ?>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active text-light txt-menu" aria-current="page" href="/proyecto_mazzanti_marcos">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Carrito">Carrito</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Quienes-Somos">Quienes Somos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Terminos-Y-Uso">Términos y Usos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Contacto">Contacto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Comercializacion">Comercialización</a>
            </li>
            
            <?php if (isset($_SESSION['usuario'])): ?>
              <li class="nav-item">
                <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/logout">Cerrar sesión</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/login">Iniciar Sesión</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Registro">Registrarse</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
