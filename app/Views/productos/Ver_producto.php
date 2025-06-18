<?php
echo '<!-- Alta_producto cargada -->';
?>
<br><br>
<div class="container mb-3 d-flex flex-column align-items-center">

    <h2>Detalles del producto</h2>
    <div class="col-4 columna-productos-principal">
        <img src="<?= base_url('assets/uploads/' . $producto['imagen']) ?>">
    </div>
    <ul class="align-items-left">
        <li><strong>ID:</strong> <?= htmlspecialchars($producto['id']) ?></li>
        <li><strong>Nombre:</strong> <?= htmlspecialchars($producto['nombre_prod']) ?></li>
        <li><strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?></li>
        <li><strong>Categoría:</strong> <?= htmlspecialchars($categoria['descripcion']) ?></li>
        <li><strong>Stock:</strong> <?= htmlspecialchars($producto['stock']) ?></li>
    </ul>
</div>

<!-- Botones de acción -->
    <div class="mt-4 d-flex gap-3 flex-wrap justify-content-center">
        <a href="<?= site_url('Producto_nuevo') ?>" class="btn btn-primary">Agregar otro producto</a>
        <a href="<?= site_url('productos/eliminar/' . $producto['id']) ?>" class="btn btn-danger">Eliminar producto</a>
        <a href="<?= site_url('productos/modificar/' . $producto['id']) ?>" class="btn btn-warning">Modificar producto</a>
    </div>
</body