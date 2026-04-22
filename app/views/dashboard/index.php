<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">Dashboard</h2>
    <p class="text-muted">
        Sistema web para la gestión de Bar/Restaurante.
    </p>

    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <h6>Reservas hoy</h6>
                    <p class="fs-4 fw-bold mb-0"><?= $reservas_hoy ?? 0 ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <h6>Usuarios</h6>
                    <p class="fs-4 fw-bold mb-0"><?= $total_usuarios ?? 0 ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <h6>Mesas ocupadas</h6>
                    <p class="fs-4 fw-bold mb-0"><?= $mesas_ocupadas ?? 0 ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <h6>Pedidos activos</h6>
                    <p class="fs-4 fw-bold mb-0"><?= $pedidos_activos ?? 0 ?></p>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5>Nueva reserva</h5>
                    <p class="flex-grow-1">Registrar una nueva reserva en el sistema.</p>
                    <a href="<?= base_url('/index.php?route=reservas.create') ?>" class="btn btn-primary w-100">
                        Ir
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5>Ver reservas</h5>
                    <p class="flex-grow-1">Consultar las reservas registradas.</p>
                    <a href="<?= base_url('/index.php?route=reservas.list') ?>" class="btn btn-success w-100">
                        Ir
                    </a>
                </div>
            </div>
        </div>

        <?php if (!empty($modulo_calendario)): ?>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5>Calendario</h5>
                    <p class="flex-grow-1">Visualizar reservas en formato calendario.</p>
                    <a href="<?= base_url('/index.php?route=reservas.calendar') ?>" class="btn btn-info w-100 text-white">
                        Ir
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($modulo_mesas)): ?>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5>Mesas</h5>
                    <p class="flex-grow-1">Gestionar mesas y su disponibilidad.</p>
                    <a href="<?= base_url('/index.php?route=mesas.list') ?>" class="btn btn-warning w-100">
                        Ir
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <div class="row">

        <?php if (!empty($modulo_productos)): ?>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5>Productos</h5>
                    <p class="flex-grow-1">Administrar el catálogo de productos.</p>
                    <a href="<?= base_url('/index.php?route=productos.list') ?>" class="btn btn-dark w-100">
                        Ir
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($modulo_pedidos)): ?>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5>Pedidos</h5>
                    <p class="flex-grow-1">Gestionar pedidos activos del sistema.</p>
                    <a href="<?= base_url('/index.php?route=pedidos.list') ?>" class="btn btn-secondary w-100">
                        Ir
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'admin' && !empty($modulo_reportes)): ?>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5>Reportes</h5>
                    <p class="flex-grow-1">Consultar ventas y estadísticas.</p>
                    <a href="<?= base_url('/index.php?route=reportes.index') ?>" class="btn btn-danger w-100">
                        Ir
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5>Rol activo</h5>
                    <p class="mb-0">
                        <?= isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'admin'
                            ? 'Administrador con control total del sistema.'
                            : 'Mesero/Cajero con acceso operativo.' ?>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>