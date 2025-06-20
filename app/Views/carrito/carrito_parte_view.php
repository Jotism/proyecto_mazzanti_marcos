<br><br>
<div class="container-fluid" id="carrito">
    <div class="cart">
        <div class="heading">
        <h2 class="text-center">Productos en tu Carrito</h2>
        <br>
        </div>
        <!-- Mostrar mensaje Flash si existe -->
        <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-warning alert-dismissible fade show mt-3 mx-3" role="alert">
            <?= session()->getFlashdata('mensaje') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php endif; ?>
    </div>
    </div>

    <div class="text-center">
    <?php if (empty($cart)): ?>
        <br>
        <p>Para agregar productos al carrito, hacé clic en:</p>
        <a class="btn btn-warning text-dark mt-2" href="<?= base_url('/Catalogo') ?>">
        <i class="fa-solid fa-circle-chevron-left"></i> Volver al catálogo
        </a>
        <br><br><br><br><br><br><br><br>
    <?php endif; ?>
    </div>
    
    <?php if (!empty($cart)): ?>
  <form action="<?= base_url('carrito_actualiza') ?>" method="post">
    <div class="container my-3">
      <table class="table table-hover table-dark table-responsive-md">
        <thead class="table-dark">
          <tr>
            <th>IMAGEN</th>
            <th>PRODUCTO</th>
            <th>PRECIO</th>
            <th>CANTIDAD</th>
            <th>TOTAL</th>
            <th>Cancelar</th>
          </tr>
        </thead>
        <tbody>
          <?php $gran_total = 0; ?>
          <?php foreach ($cart as $item): ?>
            <?php
              $gran_total += $item['price'] * $item['qty'];
            ?>
            <!-- con inputs ocultos, el usuario no ve esos datos pero el formulario los envía.-->
            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][id]" value="<?= esc($item['id']) ?>">
            <!-- usando esc() se asegura que los datos se pasen seguros para imprimir en Html -->
            <!-- cart es un arreglo multidimensional -->
            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][rowid]" value="<?= esc($item['rowid']) ?>">
            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][name]" value="<?= esc($item['name']) ?>">
            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][price]" value="<?= esc($item['price']) ?>">
            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][qty]" value="<?= esc($item['qty']) ?>">
            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][imagen]" value="<?= esc($item['imagen']) ?>">

            <tr class="table-danger align-middle">
              <td><img src="<?= base_url('assets/uploads/' . $item['imagen']) ?>" width="80" height="80"></td>
              <td><?= esc($item['name']) ?></td>
              <td><?= number_format($item['price'], 2) ?></td>
              <td>
                <a class="btn btn-sm btn-success" href="<?= base_url('carrito_suma/' . $item['rowid']) ?>">+</a>
                <?= number_format($item['qty']) ?>
                <a class="btn btn-sm btn-danger" href="<?= base_url('carrito_resta/' . $item['rowid']) ?>">-</a>
              </td>
              <td><?= number_format($item['subtotal'], 2) ?></td>
              <td>
                <a href="<?= base_url('carrito_elimina/' . $item['rowid']) ?>">
                  <img src="<?= base_url('assets/img/carrito.png') ?>" width="40" height="40" alt="Eliminar">
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr class="table-light">
            <td colspan="4"><strong>Total: $ <?= number_format($gran_total, 2) ?></strong></td>
            <td colspan="2" class="text-end">
                <input type="button" class="btn btn-danger btn-lg" value="Borrar Carrito" onclick="window.location='<?= base_url('borrar') ?>'">
                <input type="button" class="btn btn-success btn-lg" value="Comprar" onclick="window.location='<?= base_url('carrito-comprar') ?>'">
            </td>
        </tr>
        </tbody>
    </table>
    </form>
    <br><br>
    <?php endif; ?>
</div>
<br>

