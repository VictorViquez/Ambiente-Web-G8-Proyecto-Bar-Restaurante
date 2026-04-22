<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Editar producto</h2>

                <form method="POST" action="<?= base_url('/index.php?route=productos.update') ?>">
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $producto['nombre'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"><?= $producto['descripcion'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="activo" <?= $producto['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= $producto['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Actualizar producto</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>