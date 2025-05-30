<!-- app/Views/Login.php -->
<div class="container mt-5">
    <h2>Iniciar Sesión</h2>
    <form method="post" action="<?= base_url('/validar-login') ?>">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario o Email</label>
            <input type="text" class="form-control" name="usuario" required>
        </div>

        <div class="mb-3">
            <label for="pass" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="pass" required>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
</div>