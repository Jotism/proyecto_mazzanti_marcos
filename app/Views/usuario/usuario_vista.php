<div class="container mt-4">
  <div class="d-flex justify-content-end">
    <a href="<?php echo site_url('/user-form') ?>" class="btn btn-success mb-2">Agregar Usuarios</a>
  </div>

  <?php
  if (isset($_SESSION['msg'])) {
      echo $_SESSION['msg'];
  }
  ?>

  <div class="mt-2">
    <table class="table table-bordered table-secondary table-hover" id="users-list">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Perfil</th>
          <th>Baja</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($users): ?>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?php echo $user['id']; ?></td>
              <td><?php echo $user['nombre']; ?></td>
              <td><?php echo $user['email']; ?></td>
              <td><?php echo $user['perfil_id']; ?></td>
              <td><?php echo $user['baja']; ?></td>
              <td>
                <a href="<?php echo base_url('editar-user/'.$user['id']); ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="<?php echo base_url('deleteLogico/'.$user['id']); ?>" class="btn btn-danger btn-sm">Borrar</a>
                <a href="<?php echo base_url('activar/'.$user['id']); ?>" class="btn btn-secondary btn-sm">Activar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Scripts de jQuery y DataTables -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    $('#users-list').DataTable();
  });
</script>
