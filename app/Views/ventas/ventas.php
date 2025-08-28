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

<?php
// ----------------------------------------------------
// AGRUPAR por Fecha (YYYY-MM-DD) + Usuario
// ----------------------------------------------------
function fechaKey($row) {
    // usa 'fecha' de la cabecera; si se llama distinto, cambiá aquí
    $raw = $row['fecha'] ?? $row['fecha_venta'] ?? $row['created_at'] ?? null;
    if (!$raw) return null;
    try {
        $dt = new DateTime($raw);
        return $dt->format('Y-m-d');
    } catch (Throwable $e) {
        return substr($raw, 0, 10);
    }
}

function fechaHumana($key) {
    if (!$key) return 'Sin fecha';
    $p = explode('-', $key);
    if (count($p) === 3) return "{$p[2]}/{$p[1]}/{$p[0]}";
    return $key;
}

$grupos = []; // clave: "$fechaKey|$usuario"
foreach ($venta as $row) {
    $fk = fechaKey($row);
    $usuario = $row['nombre'] ?? 'Sin usuario';
    $precio_unit = isset($row['precio_vta']) ? (float)$row['precio_vta'] : (float)($row['precio'] ?? 0);
    $cantidad = max(1, (int)($row['cantidad'] ?? 1));
    $clave = ($fk ?? 'nofecha') . '|' . $usuario;

    if (!isset($grupos[$clave])) {
        $grupos[$clave] = [
            'fechaKey' => $fk,
            'fechaHuman' => fechaHumana($fk),
            'usuario' => $usuario,
            'items' => []
        ];
    }

    // duplicar por unidad (1x1)
    for ($i = 0; $i < $cantidad; $i++) {
      $grupos[$clave]['items'][] = [
        'nombre_prod' => $row['nombre_prod'],
        'imagen' => $row['imagen'],
        'precio_unit' => $precio_unit
      ];
    }
}

// ordenar por fecha desc, luego usuario
uasort($grupos, function($a, $b){
    $fa = $a['fechaKey'] ?? '';
    $fb = $b['fechaKey'] ?? '';
    if ($fa === $fb) return strcmp($a['usuario'], $b['usuario']);
    return strcmp($fb, $fa);
});
?>

<div class="container my-4">
  <h1 class="text-center mb-4">Ventas (por Fecha y Usuario)</h1>

  <!-- FILTRO RANGO DE FECHAS -->
  <div class="row g-2 align-items-end mb-3">
    <div class="col-sm-6 col-md-3">
      <label for="fechaDesde" class="form-label"><strong>Desde</strong></label>
      <input type="date" id="fechaDesde" class="form-control">
    </div>
    <div class="col-sm-6 col-md-3">
      <label for="fechaHasta" class="form-label"><strong>Hasta</strong></label>
      <input type="date" id="fechaHasta" class="form-control">
    </div>
    <div class="col-sm-6 col-md-2">
      <button id="btnAplicar" class="btn btn-primary w-100">Aplicar</button>
    </div>
    <div class="col-sm-6 col-md-2">
      <button id="btnLimpiar" class="btn btn-secondary w-100">Limpiar</button>
    </div>
  </div>

  <!-- LISTA: GRUPOS -->
  <div id="listaGrupos">
    <?php foreach ($grupos as $gkey => $g): ?>
      <?php
        // total del grupo
        $totalGrupo = 0.0;
        foreach ($g['items'] as $it) $totalGrupo += (float)$it['precio_unit'];
      ?>
      <div class="card mb-3 grupo-venta" data-fecha="<?= esc($g['fechaKey'] ?? '') ?>">
        <div class="card-header d-flex justify-content-between flex-wrap">
          <div>
            <strong>Fecha:</strong> <?= esc($g['fechaHuman']) ?>
            &nbsp; | &nbsp;
            <strong>Usuario:</strong> <?= esc($g['usuario']) ?>
          </div>
          <div>
            <strong>Total del grupo:</strong> $<?= number_format($totalGrupo, 2) ?>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm m-0 align-middle">
              <thead class="table-dark">
                <tr class="text-center">
                  <th style="width: 40%;">Producto</th>
                  <th style="width: 20%;">Imagen</th>
                  <th style="width: 20%;">Precio Unitario</th>
                  <th style="width: 20%;">Sub-Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($g['items'] as $it): ?>
                  <tr class="prod-row text-center" data-valor="<?= htmlspecialchars(number_format($it['precio_unit'], 2, '.', ''), ENT_QUOTES) ?>">
                    <td><?= esc($it['nombre_prod']) ?></td>
                    <td>
                      <img src="<?= base_url('assets/uploads/' . esc($it['imagen'])) ?>" alt=""
                        width="100" height="55" style="object-fit:cover">
                    </td>
                    <td>$<?= number_format($it['precio_unit'], 2) ?></td>
                    <td>$<?= number_format($it['precio_unit'], 2) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    <?php endforeach; ?>
  </div>

  <!-- SUBTOTAL GLOBAL DINÁMICO -->
  <div class="mt-4 text-end">
    <h4>Subtotal mostrado: <span id="totalGeneral">$0.00</span></h4>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(function(){
      // funciones parseYmd, isDateInRange, actualizarTotal, aplicarFiltroRango
      function parseYmd(ymd) {
        if (!ymd) return null;
        var p = ymd.split('-');
        if (p.length !== 3) return null;
        return new Date(p[0], parseInt(p[1],10)-1, p[2]);
      }

      function isDateInRange(fechaYmd, desdeVal, hastaVal) {
        if (!fechaYmd) return false;
        var f = parseYmd(fechaYmd);
        var desde = desdeVal ? parseYmd(desdeVal) : null;
        var hasta = hastaVal ? parseYmd(hastaVal) : null;
        if (!desde && !hasta) return true;
        if (desde && hasta) return (f >= desde && f <= hasta);
        if (desde) return (f >= desde);
        if (hasta) return (f <= hasta);
        return true;
      }

      function actualizarTotal() {
        var total = 0;
        $('.grupo-venta:visible').each(function(){
          $(this).find('.prod-row').each(function(){
            var v = parseFloat($(this).data('valor')) || 0;
            total += v;
          });
        });
        $('#totalGeneral').text('$' + total.toLocaleString(undefined, {minimumFractionDigits: 2}));
      }

      function aplicarFiltroRango() {
        var desdeVal = $('#fechaDesde').val();
        var hastaVal = $('#fechaHasta').val();

        if (!desdeVal && !hastaVal) {
          $('.grupo-venta').show();
        } else {
          $('.grupo-venta').each(function(){
            var f = $(this).data('fecha');
            $(this).toggle(isDateInRange(f, desdeVal, hastaVal));
          });
        }
        actualizarTotal();
      }

      $('#btnAplicar').on('click', aplicarFiltroRango);
      $('#btnLimpiar').on('click', function(){
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        aplicarFiltroRango();
      });

      // total inicial
      actualizarTotal();
    });
  </script>

<?php } ?>
