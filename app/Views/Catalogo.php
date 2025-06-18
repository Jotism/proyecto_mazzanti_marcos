<!-- ----------------------------- GRID ------------------------------ -->
<div class="conteiner colorF">
    <div class="row">
        <div class="col-md-1"></div> <!-- COLUMNA IZDA. GRID -->

        <div class="col"> <!-- COLUMNA CENTRAL GRID -->
            <div class="row">
                <div class="col-md-12">

                    <?php if (!$productos) { ?>
                        <div class="container-Fluid">
                            <div class="well">
                                <h2 class="text-center tit">No hay Productos</h2>
                            </div>
                        </div>
                    <?php } else { ?>

                        <div class="container-Fluid mt-2 mb-3">
                            <h2 class="text-center tit">Todos los Productos</h2>
                        </div>

                        <?php foreach ($productos as $row): ?>
                            <div class="producto-card">
                                <?= form_open('carrito_agrega'); ?>
                                    <?= form_hidden('id', $row['id']); ?>
                                    <?= form_hidden('precio_vta', $row['precio_vta']); ?>
                                    <?= form_hidden('nombre_prod', $row['nombre_prod']); ?>
                                    <!-- <?= form_hidden('qty', $row['stock']); ?> -->

                                    <div>
                                        <?php
                                        $btn = array(
                                            'class' => 'btn btn-secondary fuenteBotones',
                                            'value' => 'Agregar al Carrito',
                                            'name'  => 'action'
                                        );
                                        echo form_submit($btn);
                                        ?>
                                    </div>
                                <?= form_close(); ?>
                            </div>
                        <?php endforeach; ?>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

