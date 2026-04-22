<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Registrar mesa</h2>

                <form method="POST" action="<?= base_url('/index.php?route=mesas.store') ?>">
                    <div class="mb-3">
                        <label for="numero_mesa" class="form-label">Número de mesa</label>
                        <input type="number" name="numero_mesa" id="numero_mesa" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="number" name="capacidad" id="capacidad" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Guardar mesa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>