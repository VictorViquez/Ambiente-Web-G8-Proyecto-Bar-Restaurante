<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="mb-3">Listado de reservas</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'admin'): ?>
                            <th>Cliente</th>
                            <th>Email</th>
                        <?php endif; ?>

                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Personas</th>
                        <th>Comentario</th>
                        <th>Estado</th>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'admin'): ?>
                            <th>Acción</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($reservas as $r): ?>
                        <tr>
                            <td><?= $r['id'] ?></td>

                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'admin'): ?>
                                <td><?= $r['nombre'] ?? '' ?></td>
                                <td><?= $r['email'] ?? '' ?></td>
                            <?php endif; ?>

                            <td><?= $r['fecha'] ?></td>
                            <td><?= $r['hora'] ?></td>
                            <td><?= $r['personas'] ?></td>
                            <td><?= $r['comentario'] ?></td>
                            <td><?= ucfirst($r['estado']) ?></td>

                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'admin'): ?>
                                <td>
                                    <form method="POST" action="<?= base_url('/index.php?route=reservas.status') ?>" class="d-flex gap-2">
                                        <input type="hidden" name="id" value="<?= $r['id'] ?>">

                                        <select name="estado" class="form-select form-select-sm">
                                            <option value="pendiente" <?= $r['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                            <option value="aprobada" <?= $r['estado'] === 'aprobada' ? 'selected' : '' ?>>Aprobada</option>
                                            <option value="rechazada" <?= $r['estado'] === 'rechazada' ? 'selected' : '' ?>>Rechazada</option>
                                        </select>

                                        <button class="btn btn-sm btn-primary">Guardar</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>