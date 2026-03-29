<?php
function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ' . base_url('/index.php?route=login'));
        exit;
    }
}

function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'admin';
}

function require_admin() {
    if (!is_admin()) {
        header('Location: ' . base_url('/index.php?route=dashboard'));
        exit;
    }
}