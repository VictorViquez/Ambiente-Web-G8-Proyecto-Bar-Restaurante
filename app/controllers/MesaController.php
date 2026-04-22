<?php
require_once __DIR__ . '/../models/Mesa.php';
require_once __DIR__ . '/../helpers/utils.php';

class MesaController {
    private $mesa;

    public function __construct($db) {
        $this->mesa = new Mesa($db);
    }

    public function list() {
        $mesas = $this->mesa->listar();
        require_once __DIR__ . '/../views/mesas/list.php';
    }

    public function createView() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        require_once __DIR__ . '/../views/mesas/create.php';
    }

    public function store() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        $numero_mesa = (int)($_POST['numero_mesa'] ?? 0);
        $capacidad = (int)($_POST['capacidad'] ?? 0);

        if ($numero_mesa <= 0 || $capacidad <= 0) {
            set_flash('danger', 'Debe completar correctamente los datos de la mesa.');
            redirect(base_url('/index.php?route=mesas.create'));
        }

        $ok = $this->mesa->crear($numero_mesa, $capacidad);

        if ($ok) {
            set_flash('success', 'Mesa registrada correctamente.');
        } else {
            set_flash('danger', 'No se pudo registrar la mesa.');
        }

        redirect(base_url('/index.php?route=mesas.list'));
    }

    public function status() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        $id = (int)($_POST['id'] ?? 0);
        $estado = clean($_POST['estado'] ?? 'disponible');

        if ($id <= 0 || !in_array($estado, ['disponible', 'ocupada'])) {
            set_flash('danger', 'Datos inválidos.');
            redirect(base_url('/index.php?route=mesas.list'));
        }

        $this->mesa->cambiarEstado($id, $estado);
        set_flash('success', 'Estado de la mesa actualizado correctamente.');
        redirect(base_url('/index.php?route=mesas.list'));
    }
}