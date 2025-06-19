<div class="container mt-5">
    <h2 class="text-center">Enviar consulta</h2>
    <form action="<?= base_url('guardar_consulta') ?>" method="post">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>

        <input type="hidden" name="email" value="<?= esc($email) ?>">
        <input type="hidden" name="email" value="<?= esc($email) ?>">
        
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Enviar consulta</button>
    </form>
</div>

<h3>Mis consultas previas</h3>

<?php if (!empty($consultas)): ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Mensaje</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($consultas as $consulta): ?>
            <tr>
                <td><?= esc($consulta['mensaje']) ?></td>
                <td>
                    <?php if (trim($consulta['respuesta']) !== 'NO'): ?>
                        ✅ Respondida
                        <p><strong>Respuesta:</strong> <?= esc($consulta['respuesta']) ?></p>
                    <?php else: ?>
                        ⏳ En espera
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No realizaste consultas aún.</p>
<?php endif; ?>


