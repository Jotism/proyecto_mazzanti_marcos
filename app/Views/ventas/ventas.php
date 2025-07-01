<br>
<?php $session = session(); ?>
<?php if (empty($venta)) { ?>
    <div class="container mt-5">
        <div class="alert alert-dark text-center" role="alert">
            <h4 class="alert-heading">No posee ventas registradas</h4>
            <hr>
            <a class="btn btn-warning my-2 w-10" href="<?= base_url('catalogo') ?>">Catálogo</a>
        </div>
    </div>
<?php } else { ?>

<!-- SELECTOR DE VISTA -->
<div class="container mt-4">
    <label for="vistaSelect"><strong>Ver ventas por:</strong></label>
    <select id="vistaSelect" class="form-select w-50 mb-4">
        <option value="productos" selected>Productos</option>
        <option value="usuarios">Usuarios</option>
    </select>
</div>

<!-- VISTA PRODUCTOS -->
<div id="vista-productos">
    <div class="row container-fluid">
        <div class="table-responsive-sm text-center table-bordered table-hover align-middle">
            <h1 class="text-center">DETALLE DE VENTAS POR PRODUCTOS</h1>

            <!-- Buscador de productos -->
            <div class="mb-3">
                <label><strong>Buscar por nombre de producto:</strong></label>
                <input type="text" id="buscador-productos" class="form-control" placeholder="Ejemplo: Celular">
            </div>

            <table class="table table-secondary table-striped rounded" id="tabla-productos">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ORDEN</th>
                        <th>USUARIO</th>
                        <th>NOMBRE PRODUCTO</th>
                        <th>IMAGEN</th>
                        <th>CANTIDAD</th>
                        <th>COSTO</th>
                        <th>SUB-TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($venta as $row): ?>
                        <?php for ($u = 0; $u < $row['cantidad']; $u++): ?>
                            <?php
                                $i++;
                                $imagen   = $row['imagen'];
                                $subtotal = $row['precio_vta'];   // precio unitario
                            ?>
                            <tr class="text-center">
                                <td><?= $i ?></td>
                                <td><?= $row['nombre']; ?></td>
                                <td><?= $row['nombre_prod']; ?></td>
                                <td><img width="100" height="55"
                                        src="<?= base_url('assets/uploads/' . $imagen) ?>"></td>
                                <td>1</td>
                                <td><?= number_format($row['precio_vta'], 2) ?></td>
                                <td><?= number_format($subtotal, 2) ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-right"><h4>Total filtrado:</h4></td>
                        <td><h4 id="totalProductos">$0.00</h4></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- VISTA USUARIOS -->
<div id="vista-usuarios" style="display: none;">
    <div class="container my-4">
        <h1 class="text-center">DETALLE DE VENTAS POR USUARIOS</h1>

        <!-- Buscador de usuarios -->
        <div class="mb-3">
            <label><strong>Buscar por usuario:</strong></label>
            <input type="text" id="buscador-usuarios" class="form-control" placeholder="Ejemplo: Marcos">
        </div>

        <div class="accordion" id="ventasAccordion">
            <?php
            // AGRUPAR ventas por ID de orden
            $ordenes = [];
            foreach ($venta as $row) {
                $orden_id = $row['id_venta'];
                $ordenes[$orden_id][] = $row;
            }
            ?>

            <?php foreach ($ordenes as $orden_id => $productos): ?>
                <?php
                    $usuario     = $productos[0]['nombre'];

                    /* (1) — total real de la orden */
                    $total_orden = 0;
                    foreach ($productos as $prod) {
                        $total_orden += $prod['precio_vta'] * $prod['cantidad'];   //
                    }
                ?>

                <div class="accordion-item venta-item" data-usuario="<?= strtolower($usuario) ?>">
                    <h2 class="accordion-header" id="heading<?= $orden_id ?>">
                        <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $orden_id ?>" aria-expanded="false"
                                aria-controls="collapse<?= $orden_id ?>">
                            Orden #<?= $orden_id ?> | Usuario: <?= $usuario ?>
                            | Total: $<?= number_format($total_orden, 2) ?>
                        </button>
                    </h2>

                    <div id="collapse<?= $orden_id ?>" class="accordion-collapse collapse"
                        aria-labelledby="heading<?= $orden_id ?>">
                        <div class="accordion-body">
                            <table class="table table-striped table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Imagen</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Sub‑Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productos as $row): ?>
                                        <?php
                                            /* (2) — precio unitario ya viene en $row['precio'] */
                                            $precio_unitario = $row['precio_vta'];

                                            for ($i = 0; $i < $row['cantidad']; $i++):
                                        ?>
                                            <tr>
                                                <td><?= esc($row['nombre_prod']) ?></td>
                                                <td><img width="100" height="55"
                                                        src="<?= base_url('assets/uploads/' . esc($row['imagen'])) ?>"></td>
                                                <td>1</td>
                                                <td>$<?= number_format($precio_unitario, 2) ?></td>
                                                <td>$<?= number_format($precio_unitario, 2) ?></td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

        </div>

        <!-- Subtotal global -->
        <div class="mt-4 text-end">
            <h4>Total filtrado: <span id="totalUsuarios">$0.00</span></h4>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<script>
$(document).ready(function () {
    // Inicializar DataTable para productos
    var tabla = $('#tabla-productos').DataTable({
    dom: 'rt',          // sin buscador/paginador generados por DT
    order: [[2, 'asc']],// ordena por “Nombre Producto”
    pageLength: 50      // ↑ mostrá 50 filas (podés poner paging:false)
    });

    // Filtro personalizado por nombre de producto
    $('#buscador-productos').on('keyup', function () {
        tabla.column(2).search(this.value).draw();
        updateTotalProductos();
    });

    //Cambia la vista
   $('#vistaSelect').on('change', function () {
        if (this.value === 'productos') {
            $('#vista-productos').show();
            $('#vista-usuarios').hide();
            updateTotalProductos();      // <-- recalcula total de productos
        } else {
            $('#vista-productos').hide();
            $('#vista-usuarios').show();
            updateTotalUsuarios();       // <-- recalcula total de usuarios
        }
    });

    // Filtro por nombre de usuario
    $('#buscador-usuarios').on('keyup', function () {
        var search = $(this).val().toLowerCase();
        $('.venta-item').each(function () {
            var usuario = $(this).data('usuario');
            $(this).toggle(usuario.includes(search));
        });
        updateTotalUsuarios();
    });

    // Total para vista productos
function updateTotalProductos () {
  let total = 0;

  $('#tabla-productos tbody tr:visible').each(function () {
    // Texto crudo del último <td>
    let txt = $(this).find('td:last').text();

    /* 1)  Eliminar todo lo que no sea dígito, punto o coma
       2)  Quitar TODOS los separadores de miles (coma o punto)
       3)  Convertir la coma decimal (si existiera) en punto
       —Con esto cubrís ambas notaciones: 1,234.56  ó 1.234,56  */
    let limpio = txt
      .replace(/[^0-9.,-]/g, '')   // quita símbolos de moneda y espacios
      .replace(/(?<=\d)[,.](?=\d{3}(?:[^\d]|$))/g, '') // borra miles
      .replace(',', '.');          // deja un único punto decimal

    const num = parseFloat(limpio);
    if (!isNaN(num)) total += num;
  });

  $('#totalProductos').text(
    '$' + total.toLocaleString(undefined, { minimumFractionDigits: 2 })
  );
}


    // Total para vista usuarios
    function updateTotalUsuarios() {
        var total = 0;
        $('.venta-item:visible').each(function () {
            var header = $(this).find('button').text();
            var match = header.match(/Total:\s*\$([0-9\.,]+)/);
            if (match) {
                total += parseFloat(match[1].replace(/,/g, '')) || 0;
            }
        });
        $('#totalUsuarios').text('$' + total.toLocaleString(undefined, {minimumFractionDigits: 2}));
    }
    
    // Calcular totales al cargar
    updateTotalProductos();
    updateTotalUsuarios();
});
</script>

<?php } ?>
