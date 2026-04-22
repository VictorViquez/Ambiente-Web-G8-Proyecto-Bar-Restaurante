<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/utils.php';

class ProductoController {
    private $producto;

    public function __construct($db) {
        $this->producto = new Producto($db);
    }

    public function list() {
        if ($_SESSION['user']['rol'] === 'admin') {
            $productos = $this->producto->listar();
        } else {
            $productos = $this->producto->listarActivos();
        }

        require_once __DIR__ . '/../views/productos/list.php';
    }

    public function createView() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        require_once __DIR__ . '/../views/productos/create.php';
    }

    public function store() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        $nombre = clean($_POST['nombre'] ?? '');
        $descripcion = clean($_POST['descripcion'] ?? '');
        $precio = (float)($_POST['precio'] ?? 0);

        if (empty($nombre) || $precio <= 0) {
            set_flash('danger', 'Debe completar correctamente los datos del producto.');
            redirect(base_url('/index.php?route=productos.create'));
        }

        $ok = $this->producto->crear($nombre, $descripcion, $precio);

        if ($ok) {
            set_flash('success', 'Producto registrado correctamente.');
        } else {
            set_flash('danger', 'No se pudo registrar el producto.');
        }

        redirect(base_url('/index.php?route=productos.list'));
    }

    public function editView() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        $id = (int)($_GET['id'] ?? 0);
        $producto = $this->producto->buscarPorId($id);

        if (!$producto) {
            set_flash('danger', 'Producto no encontrado.');
            redirect(base_url('/index.php?route=productos.list'));
        }

        require_once __DIR__ . '/../views/productos/edit.php';
    }

    public function update() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        $id = (int)($_POST['id'] ?? 0);
        $nombre = clean($_POST['nombre'] ?? '');
        $descripcion = clean($_POST['descripcion'] ?? '');
        $precio = (float)($_POST['precio'] ?? 0);
        $estado = clean($_POST['estado'] ?? 'activo');

        if ($id <= 0 || empty($nombre) || $precio <= 0 || !in_array($estado, ['activo', 'inactivo'])) {
            set_flash('danger', 'Datos inválidos.');
            redirect(base_url('/index.php?route=productos.list'));
        }

        $this->producto->actualizar($id, $nombre, $descripcion, $precio, $estado);
        set_flash('success', 'Producto actualizado correctamente.');
        redirect(base_url('/index.php?route=productos.list'));
    }

    public function status() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        $id = (int)($_POST['id'] ?? 0);
        $estado = clean($_POST['estado'] ?? 'activo');

        if ($id <= 0 || !in_array($estado, ['activo', 'inactivo'])) {
            set_flash('danger', 'Datos inválidos.');
            redirect(base_url('/index.php?route=productos.list'));
        }

        $this->producto->cambiarEstado($id, $estado);
        set_flash('success', 'Estado del producto actualizado.');
        redirect(base_url('/index.php?route=productos.list'));
    }
}