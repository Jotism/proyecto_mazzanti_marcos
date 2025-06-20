<br>
<div class="container mt-1 mb-1 d-flex justify-content-center">
    <div class="card" style="width:75%;">
        <div class="card-header text-center">
            <h2>Modificar Productos</h2>
        </div>

        <?php $validation = \Config\Services::validation(); ?>

        <!-- Inicio del formulario -->
        <form action="<?= base_url('modifica/' . $producto['id']) ?>" method="post" enctype="multipart/form-data">
            
            <div class="card-body" media="(max-width:568px)">

                <!-- Nombre del producto -->
                <div class="mb-2">
                    <label for="nombre_prod" class="form-label">Producto</label>
                    <input class="form-control" type="text" name="nombre_prod" id="nombre_prod" value="<?= esc($producto['nombre_prod']) ?>" autofocus>
                    <?php if ($validation->getError('nombre_prod')): ?>
                        <div class="alert alert-danger mt-2"><?= $validation->getError('nombre_prod'); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Categoría -->
                <div class="mb-2">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-control" name="categoria" id="categoria">
                        <option value="<?php
                                foreach ($categorias as $cat) {
                                    if ($cat['id'] == $producto['categoria_id']) {
                                        echo $cat['descripcion'];
                                        break;
                                    }
                                }
                            ?>" selected>
                        </option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id']; ?>" <?= set_select('categoria', $categoria['id']); ?>>
                                <?= $categoria['id'] . ". " . $categoria['descripcion']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($validation->getError('categoria')): ?>
                        <div class="alert alert-danger mt-2"><?= $validation->getError('categoria'); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Precio de costo -->
                <div class="mb-2">
                    <label for="precio" class="form-label">Precio de Costo</label>
                    <input class="form-control" type="text" name="precio" id="precio" value="<?= esc($producto['precio']) ?>" autofocus>
                    <?php if ($validation->getError('precio')): ?>
                        <div class="alert alert-danger mt-2"><?= $validation->getError('precio'); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Precio de venta -->
                <div class="mb-2">
                    <label for="precio_vta" class="form-label">Precio de Venta</label>
                    <input class="form-control" type="text" name="precio_vta" id="precio_vta" value="<?= esc($producto['precio_vta']) ?>" autofocus>
                    <?php if ($validation->getError('precio_vta')): ?>
                        <div class="alert alert-danger mt-2"><?= $validation->getError('precio_vta'); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Stock -->
                <div class="mb-2">
                    <label for="stock" class="form-label">Stock</label>
                    <input class="form-control" type="text" name="stock" id="stock" value="<?= esc($producto['stock']) ?>" autofocus>
                    <?php if ($validation->getError('stock')): ?>
                        <div class="alert alert-danger mt-2"><?= $validation->getError('stock'); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Stock mínimo -->
                <div class="mb-2">
                    <label for="stock_min" class="form-label">Stock Mínimo</label>
                    <input class="form-control" type="text" name="stock_min" id="stock_min" value="<?= esc($producto['stock_min']) ?>" autofocus>
                    <?php if ($validation->getError('stock_min')): ?>
                        <div class="alert alert-danger mt-2"><?= $validation->getError('stock_min'); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Imagen -->
                <div class="mb-2">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input class="form-control" type="file" name="imagen" id="imagen" accept="image/png, image/jpg, image/jpeg">
                    <?php if ($validation->getError('imagen')): ?>
                        <div class="alert alert-danger mt-2"><?= $validation->getError('imagen'); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Botones -->
                <div class="form-group">
                    <button type="submit" id="send_form" class="btn btn-success">Enviar</button>
                    <button type="reset" class="btn btn-danger">Cancelar</button>
                    <a href="<?= base_url('/Catalogo'); ?>" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </form> <!-- Fin del formulario -->
    </div>
</div>

