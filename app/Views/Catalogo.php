<div class="container mt-4">
    <h1 class="mb-4 text-center">Catalago</h1>

    <!-- Filtro por marca -->
    <form method="get" action="<?= base_url('catalogo-filtrado') ?>" class="mb-4">
        <select name="categoria" class="form-select" onchange="this.form.submit()">
            <option value="">-- Ver todas las marcas --</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= (isset($categoriaSeleccionada) && $categoriaSeleccionada == $cat['id']) ? 'selected' : '' ?>>
                    <?= $cat['descripcion'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Mostrar productos -->
    <div class="row">
        <?php if (!empty($productos)): ?>
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
                                                <?= form_hidden('imagen', $row['imagen']); ?>

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
        <?php else: ?>
            <p class="text-center">No hay productos disponibles.</p>
        <?php endif; ?>
    </div>
</div>

