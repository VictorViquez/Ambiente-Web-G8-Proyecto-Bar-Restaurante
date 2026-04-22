<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Crear pedido</h2>

                <form method="POST" action="<?= base_url('/index.php?route=pedidos.store') ?>">
                    <div class="mb-3">
                        <label for="mesa_id" class="form-label">Mesa</label>
                        <select name="mesa_id" id="mesa_id" class="form-select" required>
                            <option value="">Seleccione una mesa</option>
                            <?php foreach ($mesas as $m): ?>
                                <option value="<?= $m['id'] ?>">
                                    Mesa <?= $m['numero_mesa'] ?> - Capacidad <?= $m['capacidad'] ?> - <?= ucfirst($m['estado']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Crear pedido</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>