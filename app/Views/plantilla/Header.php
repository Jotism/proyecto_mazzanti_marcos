

<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <div class="Titulo">
    <title>Xport | <?php echo $titulo?></title>
    </div>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/miestilo.css') ?>">
  </head>
  <body class="bg-primary">

    <nav class="navbar navbar-expand-lg bg-secondary">
        <div class="container-fluid">
          <a class="navbar-brand" href="/proyecto_mazzanti_marcos"><img src="<?= base_url('assets/img/logo-xport-blanco.png') ?>" class="img-logo-menu"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

            <?php if(session('perfil_id') == 1): ?>
                <div class="btn btn-danger active btnUser btn-sm">
                  <a href="">USUARIO: <?php echo session('nombre'); ?></a>
                </div>
            <?php elseif (session('perfil_id') == 2): ?>
                <div class="btn btn-danger active btnUser btn-sm ms-2">
                  <a href="">CLIENTE: <?= session('nombre'); ?></a>
                </div>
            <?php endif; ?>

            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <?php if (session('perfil_id') == 1): ?>
                    <li class="nav-item">
                      <a class="nav-link active text-light txt-menu" href="/proyecto_mazzanti_marcos">Inicio</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-light txt-menu" href="<?= base_url('/users-list') ?>">CrudUsuarios</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-light txt-menu" href="<?= base_url('/listar_consultas') ?>">Gestión Consultas</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-light txt-menu" href="<?= base_url('/crear') ?>">CrudProductos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-light txt-menu" href="<?= base_url('/ventas') ?>">Muestra Ventas</a>
                    </li>
                  <?php else: ?>
                    <li class="nav-item">
                    <a class="nav-link active text-light txt-menu" aria-current="page" href="/proyecto_mazzanti_marcos">Inicio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Catalogo">Catalogo</a>
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
                  <li class="nav-item">
                    <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/muestra">Carrito</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light txt-menu" href="/proyecto_mazzanti_marcos/Consultas-Cliente">Consultas</a>
                  </li>
                  <?php endif; ?>

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