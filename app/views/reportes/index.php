<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Reportes de ventas</h2>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= base_url('/index.php') ?>">
            <input type="hidden" name="route" value="reportes.index">

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?= $fecha_inicio ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= $fecha_fin ?>">
                </div>

                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Generar reporte</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">

    <div class="col-md-6 mb-3">
        <div class="card shadow-sm text-center h-100">
            <div class="card-body">
                <h5>Total de pedidos cerrados</h5>
                <p class="fs-3 fw-bold mb-0"><?= $resumen['total_pedidos'] ?? 0 ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card shadow-sm text-center h-100">
            <div class="card-body">
                <h5>Total vendido</h5>
                <p class="fs-3 fw-bold mb-0">₡<?= number_format($resumen['total_vendido'] ?? 0, 2) ?></p>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Detalle de ventas</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID Pedido</th>
                        <th>Fecha</th>
                        <th>Mesa</th>
                        <th>Usuario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detalles)): ?>
                        <?php foreach ($detalles as $d): ?>
                            <tr>
                                <td><?= $d['id'] ?></td>
                                <td><?= $d['fecha'] ?></td>
                                <td>Mesa <?= $d['numero_mesa'] ?></td>
                                <td><?= $d['usuario_nombre'] ?></td>
                                <td>₡<?= number_format($d['total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay ventas cerradas en ese rango de fechas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>