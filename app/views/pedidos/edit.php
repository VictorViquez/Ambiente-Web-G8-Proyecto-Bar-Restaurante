<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="mb-4">
    <h2>Pedido #<?= $pedido['id'] ?></h2>
    <p class="text-muted mb-1">Mesa <?= $pedido['numero_mesa'] ?> | Usuario: <?= $pedido['usuario_nombre'] ?></p>
    <p class="text-muted">Estado: <?= ucfirst($pedido['estado']) ?> | Total: ₡<?= number_format($pedido['total'], 2) ?></p>
</div>

<?php if ($pedido['estado'] === 'activo'): ?>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Agregar producto</h5>

        <form method="POST" action="<?= base_url('/index.php?route=pedidos.addDetail') ?>">
            <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="producto_id" class="form-label">Producto</label>
                    <select name="producto_id" id="producto_id" class="form-select" required>
                        <option value="">Seleccione un producto</option>
                        <?php foreach ($productos as $prod): ?>
                            <option value="<?= $prod['id'] ?>">
                                <?= $prod['nombre'] ?> - ₡<?= number_format($prod['precio'], 2) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                </div>

                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Detalle del pedido</h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detalles)): ?>
                        <?php foreach ($detalles as $d): ?>
                            <tr>
                                <td><?= $d['producto_nombre'] ?></td>
                                <td><?= $d['cantidad'] ?></td>
                                <td>₡<?= number_format($d['precio_unitario'], 2) ?></td>
                                <td>₡<?= number_format($d['subtotal'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay productos agregados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <strong>Total pedido: ₡<?= number_format($pedido['total'], 2) ?></strong>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>