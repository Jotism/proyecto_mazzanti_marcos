<?php if (empty($consultas)) { ?>
    <!-- avisamos que no hay consultas -->
    <br><br><br><br>
    <div class="container">
        <div class="alert alert-dark text-center" role="alert">
            <h4 class="alert-heading">No hay consultas por atender</h4>
            <p>No hay consultas disponibles en este momento.</p>
            <hr>
            <p class="mb-0">Por favor, regrese más tarde.</p>
        </div>
    </div>
    <br><br><br><br><br>
<?php } else { ?>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Consultas</h2>
        <!-- mostramos la tabla consultas -->
            <div class="table-responsive-sm">
        <table class="table table-bordered text-center table-warning">
        <thead>
            <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Mensaje</th>
            <th>¿Se respondió?</th>
            <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= esc($consulta['nombre']) ?></td>
                    <td><?= esc($consulta['email']) ?></td>
                    <td><?= esc($consulta['mensaje']) ?></td>
                    <td>
                    <?= ($consulta['respuesta'] !== 'NO') 
                        ? '<span class="text-success">Su consulta ya ha sido resuelta</span>' 
                        : 'NO' ?>
                    </td>
                    <td>
                    <!-- Botón para mostrar el formulario -->
                    <button class="btn btn-primary btn-sm mb-1" onclick="mostrarFormulario(<?= $consulta['id_consulta'] ?>)">Atender</button>

                    <!-- Botón para eliminar -->
                    <a href="<?= base_url('eliminar_consulta/'.$consulta['id_consulta']) ?>" class="btn btn-danger btn-sm mb-1">Eliminar</a>
                    </td>
                </tr>

                <!-- Formulario oculto -->
                <tr id="formulario-<?= $consulta['id_consulta'] ?>" style="display: none;">
                    <td colspan="5">
                    <form action="<?= base_url('responder_consulta') ?>" method="post" class="form-inline justify-content-center">
                        <input type="hidden" name="id_consulta" value="<?= $consulta['id_consulta'] ?>">
                        <div class="form-group mx-sm-3 mb-2">
                        <input type="text" name="respuesta" class="form-control" placeholder="Escriba la respuesta..." required>
                        </div>
                        <button type="submit" class="btn btn-success mb-2">Enviar</button>
                    </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
    </div>
<?php } ?>

<script>
  function mostrarFormulario(id) {
    var filaForm = document.getElementById("formulario-" + id);
    filaForm.style.display = (filaForm.style.display === "none") ? "table-row" : "none";
  }
</script>
