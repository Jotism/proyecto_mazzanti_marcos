<!-- ----------------------------- GRID ------------------------------ -->
<div class="container colorF">
    <div class="row">
        <div class="col-md-1"></div> <!-- Columna izquierda -->
        <div class="col"> <!-- Columna central -->

            <div class="row">
                <div class="col-md-12">
                    <?php if (!$productos) { ?>
                        <div class="container-fluid">
                            <div class="well">
                                <h2 class="text-center tit">No hay Productos</h2>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="container-fluid mt-2 mb-3">
                            <h2 class="text-center tit">Todos los Productos</h2>
                        </div>

                        <div class="row">
                            <?php foreach ($productos as $row) { ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="<?= base_url('assets/uploads/' . $row['imagen']) ?>" class="card-img-top" alt="<?= $row['nombre_prod'] ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $row['nombre_prod'] ?></h5>
                                            <p class="card-text">$<?= number_format($row['precio_vta'], 2, ',', '.') ?></p>

                                            <?= form_open('carrito/add'); ?>
                                                <?= form_hidden('id', $row['id']); ?>
                                                <?= form_hidden('precio_vta', $row['precio_vta']); ?>
                                                <?= form_hidden('nombre_prod', $row['nombre_prod']); ?>

                                                <?php
                                                $btn = array(
                                                    'class' => 'btn btn-primary btn-block fuenteBotones',
                                                    'value' => 'Agregar al Carrito',
                                                    'name' => 'action'
                                                );
                                                echo form_submit($btn);
                                                echo form_close();
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>
