<br><br><br>
<?php
$session = session();
if (empty($venta)) { ?>
    <!-- Avisamos que no hay consultas -->
    <div class="container">
        <div class="alert alert-dark text-center" role="alert">
            <h4 class="alert-heading">No posee compras registradas</h4>
            <p>Para realizar una compra visite nuestro catálogo.</p>
            <hr>
            <a class="btn btn-warning my-2 w-10" href="<?= base_url('catalogo') ?>">Catálogo</a>
        </div>
    </div>
<?php } ?>

<!-- Mostrar mensaje Flash si existe -->
<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-warning alert-dismissible fade show mt-3 mx-3" role="alert">
        <?= session()->getFlashdata('mensaje') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="container">
        <div class="col-xl-12 col-xs-10">
            <table class="table table-secondary table-responsive table-bordered table-striped rounded">
                <thead>
                    <tr class="text-center">
                        <th>N° ORDEN</th>
                        <th>NOMBRE PRODUCTO</th>
                        <th>IMAGEN</th>
                        <th>CANTIDAD</th>
                        <th>COSTO</th>
                        <th>COSTO SUB-TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $total = 0;
                    // Si es array de ventas y no está vacío
                    if (!empty($venta) && is_array($venta)) {
                        foreach ($venta as $row) {
                            $imagen = $row['imagen'];
                            // $total = $row['precio'];
                    ?>
                    <tr class="text-center">
                        <th><?= $i++ ?></th>
                        <td><?= $row['nombre_prod'] ?></td>
                        <td><img width="100" height="65" src="<?= base_url('assets/uploads/' . $imagen) ?>"></td>
                        <td><?= number_format($row['cantidad']) ?></td>
                        <td>$<?= number_format($row['precio_vta'], 2) ?></td>
                        <?php $subtotal = ($row['precio_vta'] * $row['cantidad']); ?>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php
                            $total += $subtotal;
                        }
                    } ?>
                </tbody>
                <tr>
                    <td colspan="5" class="text-right"><h4>Total</h4></td>
                    <td colspan="6" class="text-right"><h4>$<?= number_format($total, 2) ?></h4></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br><br><br>
<div class="row">
    <div class="col-xl-12 col-xs-12 text-center">
        <div class="h2 gracias-factura">Gracias por su compra</div>
    </div>
</div>
<br><br>
