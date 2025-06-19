<?php if (empty($consultas)) { ?>
    <!-- avisamos que no hay consultas -->
    <div class="container">
        <div class="alert alert-dark text-center" role="alert">
            <h4 class="alert-heading">No hay consultas por atender</h4>
            <p>No hay consultas disponibles en este momento.</p>
            <hr>
            <p class="mb-0">Por favor, regrese más tarde.</p>
        </div>
    </div>
<?php } else { ?>
    <div class="container-fluid">
        <h1 class="titulos-dark rounded p-2 text-center">Consultas</h1>
        <!-- mostramos la tabla consultas -->
        <div class="table-responsive-sm">
            <table id="mytable" class="table table-warning table-striped rounded">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Mensaje</th>
                        <th>¿Se respondió?</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $row) { ?>
                        <tr>
                            <td><?php echo $row['nombre'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['mensaje'] ?></td>
                            <td><?php echo $row['respuesta'] ?></td>
                            <td>
                                <?php if ($row['respuesta'] == 'NO') { ?>
                                    <a href="<?php echo base_url('atender_consulta/' . $row['id_consulta']) ?>" class="btn btn-success btn-sm">
                                        Atender
                                    </a>
                                <?php } ?>
                                <?php if ($row['respuesta'] == 'SI') { ?>
                                    <a href="<?php echo base_url('eliminar_consulta/' . $row['id_consulta']) ?>" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
