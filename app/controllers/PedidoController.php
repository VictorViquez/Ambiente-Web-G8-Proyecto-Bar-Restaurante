<?php
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Mesa.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/utils.php';

class PedidoController {
    private $pedido;
    private $mesa;
    private $producto;

    public function __construct($db) {
        $this->pedido = new Pedido($db);
        $this->mesa = new Mesa($db);
        $this->producto = new Producto($db);
    }

    public function list() {
        $pedidos = $this->pedido->listar();
        require_once __DIR__ . '/../views/pedidos/list.php';
    }

    public function createView() {
        $mesas = $this->mesa->listar();
        require_once __DIR__ . '/../views/pedidos/create.php';
    }

    public function store() {
        $mesa_id = (int)($_POST['mesa_id'] ?? 0);
        $usuario_id = $_SESSION['user']['id'];

        if ($mesa_id <= 0) {
            set_flash('danger', 'Debe seleccionar una mesa.');
            redirect(base_url('/index.php?route=pedidos.create'));
        }

        $pedido_id = $this->pedido->crear($mesa_id, $usuario_id);

        if ($pedido_id) {
            set_flash('success', 'Pedido creado correctamente.');
            redirect(base_url('/index.php?route=pedidos.edit&id=' . $pedido_id));
        } else {
            set_flash('danger', 'No se pudo crear el pedido.');
            redirect(base_url('/index.php?route=pedidos.create'));
        }
    }

    public function editView() {
        $id = (int)($_GET['id'] ?? 0);
        $pedido = $this->pedido->buscarPorId($id);

        if (!$pedido) {
            set_flash('danger', 'Pedido no encontrado.');
            redirect(base_url('/index.php?route=pedidos.list'));
        }

        $productos = $this->producto->listarActivos();
        $detalles = $this->pedido->obtenerDetalles($id);

        require_once __DIR__ . '/../views/pedidos/edit.php';
    }

    public function addDetail() {
        $pedido_id = (int)($_POST['pedido_id'] ?? 0);
        $producto_id = (int)($_POST['producto_id'] ?? 0);
        $cantidad = (int)($_POST['cantidad'] ?? 0);

        if ($pedido_id <= 0 || $producto_id <= 0 || $cantidad <= 0) {
            set_flash('danger', 'Debe completar correctamente los datos del detalle.');
            redirect(base_url('/index.php?route=pedidos.edit&id=' . $pedido_id));
        }

        $ok = $this->pedido->agregarDetalle($pedido_id, $producto_id, $cantidad);

        if ($ok) {
            set_flash('success', 'Producto agregado al pedido.');
        } else {
            set_flash('danger', 'No se pudo agregar el producto.');
        }

        redirect(base_url('/index.php?route=pedidos.edit&id=' . $pedido_id));
    }

    public function close() {
        $pedido_id = (int)($_POST['pedido_id'] ?? 0);

        if ($pedido_id <= 0) {
            set_flash('danger', 'Pedido inválido.');
            redirect(base_url('/index.php?route=pedidos.list'));
        }

        $this->pedido->cerrar($pedido_id);
        set_flash('success', 'Pedido cerrado correctamente.');
        redirect(base_url('/index.php?route=pedidos.list'));
    }
}