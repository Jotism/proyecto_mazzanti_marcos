<div class="container mt-5 mb-5">
    <div class="card-header text-justify">
        <div class="row d-flex justify-content-center">
            <div class="card col-lg-3" style="width: 50%;">
                <br>
                <h4>Registrarse</h4>
                <?php $validation = \Config\Services::validation(); ?>
                <form method="post" action="<?= base_url('/enviar-form') ?>">
                    <?= csrf_field(); ?>
                    
                    <?php if(!empty(session()->getFlashdata('fail'))): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                    <?php endif; ?>
                    
                    <?php if(!empty(session()->getFlashdata('success'))): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>

                    <div class="card-body justify-content-center" media="(max-width:768px)">
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                            <input name="nombre" type="text" class="form-control" placeholder="nombre">
                            <?php if($validation->getError('nombre')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= $validation->getError('nombre'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control" placeholder="apellido">
                            <?php if($validation->getError('apellido')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= $validation->getError('apellido'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea2" class="form-label">usuario</label>
                            <input type="text" name="usuario" class="form-control" placeholder="usuario">
                            <?php if($validation->getError('usuario')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= $validation->getError('usuario'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea3" class="form-label">email</label>
                            <input type="text" name="email" class="form-control" placeholder="email">
                            <?php if($validation->getError('email')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= $validation->getError('email'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea4" class="form-label">contraseña</label>
                            <input type="text" name="pass" class="form-control" placeholder="contraseña">
                            <?php if($validation->getError('pass')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= $validation->getError('pass'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>