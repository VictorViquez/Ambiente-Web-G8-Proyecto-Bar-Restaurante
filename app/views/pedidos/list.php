<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Pedidos</h2>
    <a href="<?= base_url('/index.php?route=pedidos.create') ?>" class="btn btn-primary">
        Nuevo pedido
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mesa</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pedidos)): ?>
                        <?php foreach ($pedidos as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td>Mesa <?= $p['numero_mesa'] ?></td>
                                <td><?= $p['usuario_nombre'] ?></td>
                                <td><?= $p['fecha'] ?></td>
                                <td>
                                    <span class="badge <?= $p['estado'] === 'activo' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= ucfirst($p['estado']) ?>
                                    </span>
                                </td>
                                <td>₡<?= number_format($p['total'], 2) ?></td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <?php if ($p['estado'] === 'activo'): ?>
                                            <a href="<?= base_url('/index.php?route=pedidos.edit&id=' . $p['id']) ?>" class="btn btn-sm btn-warning">
                                                Gestionar
                                            </a>

                                            <form method="POST" action="<?= base_url('/index.php?route=pedidos.close') ?>">
                                                <input type="hidden" name="pedido_id" value="<?= $p['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Cerrar
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?= base_url('/index.php?route=pedidos.edit&id=' . $p['id']) ?>" class="btn btn-sm btn-secondary">
                                                Ver
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No hay pedidos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>