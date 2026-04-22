<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Mesas</h2>

    <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
        <a href="<?= base_url('/index.php?route=mesas.create') ?>" class="btn btn-primary">
            Nueva mesa
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Número de mesa</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                            <th>Acción</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mesas)): ?>
                        <?php foreach ($mesas as $m): ?>
                            <tr>
                                <td><?= $m['id'] ?></td>
                                <td><?= $m['numero_mesa'] ?></td>
                                <td><?= $m['capacidad'] ?></td>
                                <td>
                                    <span class="badge <?= $m['estado'] === 'ocupada' ? 'bg-danger' : 'bg-success' ?>">
                                        <?= ucfirst($m['estado']) ?>
                                    </span>
                                </td>

                                <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                                <td>
                                    <form method="POST" action="<?= base_url('/index.php?route=mesas.status') ?>" class="d-flex gap-2">
                                        <input type="hidden" name="id" value="<?= $m['id'] ?>">

                                        <select name="estado" class="form-select form-select-sm">
                                            <option value="disponible" <?= $m['estado'] === 'disponible' ? 'selected' : '' ?>>
                                                Disponible
                                            </option>
                                            <option value="ocupada" <?= $m['estado'] === 'ocupada' ? 'selected' : '' ?>>
                                                Ocupada
                                            </option>
                                        </select>

                                        <button type="submit" class="btn btn-sm btn-warning">
                                            Actualizar
                                        </button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= $_SESSION['user']['rol'] === 'admin' ? 5 : 4 ?>" class="text-center">
                                No hay mesas registradas.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>