<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Productos</h2>

    <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
        <a href="<?= base_url('/index.php?route=productos.create') ?>" class="btn btn-primary">
            Nuevo producto
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= $p['nombre'] ?></td>
                                <td><?= $p['descripcion'] ?></td>
                                <td>₡<?= number_format($p['precio'], 2) ?></td>
                                <td>
                                    <span class="badge <?= $p['estado'] === 'activo' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= ucfirst($p['estado']) ?>
                                    </span>
                                </td>

                                <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="<?= base_url('/index.php?route=productos.edit&id=' . $p['id']) ?>" class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form method="POST" action="<?= base_url('/index.php?route=productos.status') ?>" class="d-flex gap-2">
                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                            <select name="estado" class="form-select form-select-sm">
                                                <option value="activo" <?= $p['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                                                <option value="inactivo" <?= $p['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-dark">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= $_SESSION['user']['rol'] === 'admin' ? 5 : 4 ?>" class="text-center">
                                No hay productos registrados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>