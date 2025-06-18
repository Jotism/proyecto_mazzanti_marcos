<br><br>
<div class="container mt-5">
    <h1 class="mb-4">Listado de Productos</h1>
    <a href="<?= base_url('/produ-form') ?>" class="btn btn-secondary mb-3">Agregar nuevo producto</a>
    <?php if (isset($productos) && count($productos) > 0): ?>
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $prod): ?>
                    <tr class="text-center">>
                        <td><?= esc($prod['id']) ?></td>
                        <td><?= esc($prod['nombre_prod']) ?></td>
                        <td>$<?= esc($prod['precio']) ?></td>
                        <td>$<?= esc($prod['precio_vta']) ?></td>
                        <td><?= esc($prod['stock']) ?></td>
                        <td>
                            <?php if (!empty($prod['imagen'])): ?>
                                <img src="<?= base_url('assets/uploads/' . $prod['imagen']) ?>" alt="Imagen del producto" class="img-thumbnail" style="width: 80px;">
                            <?php else: ?>
                                <span class="text-muted">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('editar/' . $prod['id']) ?>" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                            <?php if ($prod['eliminado'] == 'NO'): ?>
                                <a href="<?= base_url('borrar/' . $prod['id']) ?>" 
                                class="btn btn-sm btn-outline-danger btn-outline-success">
                                Desactivar
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('activar_pro/' . $prod['id']) ?>" 
                                class="btn btn-sm btn-outline-danger btn-outline-success">
                                Activar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay productos cargados.</div>
    <?php endif; ?>
</div>