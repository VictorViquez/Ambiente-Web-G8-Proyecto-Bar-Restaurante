<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Iniciar sesión</h2>

                <form method="POST" action="<?= base_url('/index.php?route=login.post') ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>

                <div class="mt-3">
                    <a href="<?= base_url('/index.php?route=register') ?>">Crear cuenta</a>
                    |
                    <a href="<?= base_url('/index.php?route=forgot') ?>">Olvidé mi contraseña</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>