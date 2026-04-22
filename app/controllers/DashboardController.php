<?php

class DashboardController {

    public function index() {
        $reservas_hoy = 0;
        $total_usuarios = 0;
        $mesas_ocupadas = 0;
        $pedidos_activos = 0;

        // Activá en true conforme vayas terminando cada módulo
        $modulo_calendario = true;
        $modulo_mesas = true;
        $modulo_productos = true;
        $modulo_pedidos = true;
        $modulo_reportes = true;

        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}