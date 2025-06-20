<div class="container mt-4">

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
            <?php foreach ($productos as $prod): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($prod['imagen'])): ?>
                            <img src="<?= base_url('uploads/' . $prod['imagen']) ?>" alt="Imagen del producto"
                                 class="card-img-top img-thumbnail" style="object-fit: cover; width: 100%; height: 200px;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $prod['nombre_prod'] ?></h5>
                            <p class="card-text"><?= $prod['precio'] ?> USD</p>

                            <!-- Botón Agregar al carrito -->
                            <form action="<?= base_url('carrito/add') ?>" method="post" class="mt-auto">
                                <input type="hidden" name="id" value="<?= $prod['id'] ?>">
                                <input type="hidden" name="nombre" value="<?= $prod['nombre_prod'] ?>">
                                <input type="hidden" name="precio" value="<?= $prod['precio'] ?>">
                                <input type="number" name="cantidad" value="1" min="1" class="form-control mb-2">
                                <button type="submit" class="btn btn-primary w-100">Agregar al carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay productos disponibles.</p>
        <?php endif; ?>
    </div>
</div>

