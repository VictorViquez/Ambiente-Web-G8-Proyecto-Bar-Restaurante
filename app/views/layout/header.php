<?php require_once __DIR__ . '/../../helpers/utils.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema SC-502</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="<?= base_url('/style.css') ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="<?= base_url('/index.php?route=dashboard') ?>">
            Bar/Restaurante SC-502
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <?php if (isset($_SESSION['user'])): ?>
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/index.php?route=dashboard') ?>">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/index.php?route=reservas.list') ?>">Reservas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/index.php?route=reservas.calendar') ?>">Calendario</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/index.php?route=mesas.list') ?>">Mesas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/index.php?route=productos.list') ?>">Productos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/index.php?route=pedidos.list') ?>">Pedidos</a>
                </li>

                <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/index.php?route=reportes.index') ?>">Reportes</a>
                </li>
                <?php endif; ?>

            </ul>
            <?php endif; ?>

            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="text-white me-3">
                        <?= $_SESSION['user']['nombre'] ?> (<?= $_SESSION['user']['rol'] ?>)
                    </span>

                    <a class="btn btn-outline-light btn-sm"
                       href="<?= base_url('/index.php?route=logout') ?>">
                        Cerrar sesión
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>

<div class="container mt-4">

    <?php $flash = get_flash(); ?>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
            <?= $flash['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>