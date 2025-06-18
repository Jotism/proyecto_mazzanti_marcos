<?php
echo '<!-- Alta_producto cargada -->';
?>
<br><br>

    <h1>Producto agregado exitosamente</h1>

    <?php if (isset($producto)): ?>
        <ul>
            <li><strong>ID:</strong> <?= esc($producto['id']) ?></li>
            <li><strong>Nombre:</strong> <?= esc($producto['nombre']) ?></li>
            <li><strong>Precio:</strong> $<?= esc($producto['precio']) ?></li>
            <li><strong>Stock:</strong> <?= esc($producto['stock']) ?></li>
            <li><strong>ID Categoría:</strong> <?= esc($producto['id_categoria']) ?></li>
            <li><strong>Activo:</strong> <?= $producto['activo'] ? 'Sí' : 'No' ?></li>
        </ul>
    <?php else: ?>
        <p>No se encontró información del producto.</p>
    <?php endif; ?>

    <a href="<?= base_url('/productos') ?>">Volver al listado</a>

