<?php
echo '<!-- Alta_producto cargada -->';
?>

<div class="container">
    <div class="success">✅ Producto agregado correctamente</div>

    <h2>Detalles del producto</h2>
    <div class="col-4 columna-productos-principal">
        <img src="<?= base_url('assets/uploads/' . $producto['imagen']) ?>">
    </div>
    <ul>
        <li><strong>ID:</strong> <?= htmlspecialchars($producto['id']) ?></li>
        <li><strong>Nombre:</strong> <?= htmlspecialchars($producto['nombre_prod']) ?></li>
        <li><strong>Precio de venta:</strong> <?= htmlspecialchars($producto['precio_vta']) ?></li>
        <li><strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?></li>
        <li><strong>Categoría:</strong> <?= htmlspecialchars($categoria['descripcion']) ?></li>
        <li><strong>Stock:</strong> <?= htmlspecialchars($producto['stock']) ?></li>
    </ul>


    <a href="<?= site_url('productos/nuevo') ?>" class="back-button">← Agregar otro producto</a>
</div>
</body