<div class="container mt-1 mb-0">
    <br>
    <div class="card mx-auto" style="width: 50%;">
        <div class="card-header text-center">
            <h5>Alta de Usuario</h5>
        </div>

        <?php $validation = \Config\Services::validation(); ?>
        <form method="post" action="<?= base_url('enviar') ?>">

            <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('fail'); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>

            <div class="card-body" media="(max-width:768px)">
                <!-- Campo Nombre -->
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                    <input name="nombre" type="text" class="form-control" placeholder="nombre" value="">
                    <?php if ($validation->getError('nombre')) : ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('nombre'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Campo Apellido -->
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" placeholder="apellido">
                    <?php if ($validation->getError('apellido')) : ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('apellido'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Campo Email -->
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="correo@algo.com">
                    <?php if ($validation->getError('email')) : ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('email'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Campo Usuario -->
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" placeholder="usuario">
                    <?php if ($validation->getError('usuario')) : ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('usuario'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Campo Password -->
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input name="pass" type="text" class="form-control" placeholder="contraseña">
                    <?php if ($validation->getError('pass')) : ?>
                        <div class="alert alert-danger mt-2">
                            <?= $validation->getError('pass'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Botones -->
                <div class="col-12" style="text-align:center;">
                    <input type="submit" value="guardar" class="btn btn-success">
                    <input type="reset" value="cancelar" class="btn btn-danger">
                    <a href="<?= base_url('users-list') ?>" class="btn btn-secondary">volver</a>
                </div>
            </div>
        </form>
    </div>
</div>
