<div class="container mt-5">
    <h2 class="text-center">Enviar consulta</h2>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('guardar_consulta') ?>" method="post">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= old('nombre') ?>" required>
        </div>
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= old('apellido') ?>" required>
        </div>

        <input type="hidden" name="email" value="<?= esc($email) ?>">

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= old('telefono') ?>" required>
        </div>
        <div class="form-group">
            <label>Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="4" required><?= old('mensaje') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Enviar consulta</button>
    </form>
</div>

<h3 class="text-center mt-4">Mis consultas previas</h3>

<?php if (!empty($consultas)): ?>
    <div class="d-flex justify-content-center mt-4">
        <div class="table-responsive" style="max-width: 900px;">
            <table class="table table-bordered table-striped shadow-sm rounded">
                <thead class="thead-dark">
                    <tr class="text-center bg-primary text-white">
                        <th>Mensaje</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $consulta): ?>
                        <tr>
                            <td style="white-space: normal;"><?= esc($consulta['mensaje']) ?></td>
                            <td style="white-space: normal; word-wrap: break-word; overflow-wrap: anywhere; max-width: 300px;">
                            <?php if (trim($consulta['respuesta']) !== 'NO'): ?>
                                <span class="badge bg-success">Respondida</span>
                                <p class="mt-2"><strong>Respuesta:</strong> <?= esc($consulta['respuesta']) ?></p>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">En espera</span>
                            <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <p class="text-center mt-4">No realizaste consultas aún.</p>
<?php endif; ?>


