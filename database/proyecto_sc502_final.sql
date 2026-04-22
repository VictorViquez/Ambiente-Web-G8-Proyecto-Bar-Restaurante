DROP DATABASE IF EXISTS proyecto_sc502;
CREATE DATABASE proyecto_sc502 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE proyecto_sc502;

-- =====================================
-- TABLA: usuarios
-- =====================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin','mesero') NOT NULL DEFAULT 'mesero',
    token_recuperacion VARCHAR(120) DEFAULT NULL,
    token_expira DATETIME DEFAULT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================
-- TABLA: reservas
-- =====================================
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    personas INT NOT NULL,
    comentario VARCHAR(255) DEFAULT NULL,
    estado ENUM('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reserva_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- =====================================
-- TABLA: mesas
-- =====================================
CREATE TABLE mesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_mesa INT NOT NULL UNIQUE,
    capacidad INT NOT NULL,
    estado ENUM('disponible','ocupada') NOT NULL DEFAULT 'disponible'
);

-- =====================================
-- TABLA: productos
-- =====================================
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    precio DECIMAL(10,2) NOT NULL,
    estado ENUM('activo','inactivo') NOT NULL DEFAULT 'activo'
);

-- =====================================
-- TABLA: pedidos
-- =====================================
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mesa_id INT NOT NULL,
    usuario_id INT NOT NULL,
    estado ENUM('activo','cerrado') NOT NULL DEFAULT 'activo',
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    CONSTRAINT fk_pedido_mesa FOREIGN KEY (mesa_id) REFERENCES mesas(id),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- =====================================
-- TABLA: detalle_pedido
-- =====================================
CREATE TABLE detalle_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_detalle_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    CONSTRAINT fk_detalle_producto FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- =====================================
-- USUARIOS SEED
-- IMPORTANTE:
-- Después de importar, corré el UPDATE de passwords
-- para dejar a todos con 123456
-- =====================================
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador', 'admin@correo.com', '$2y$12$/g7T3A8ZFQkDc0ZTd6Z2RehtLZRcpsifgs0KnFs.O51r.vNXZbe9y', 'admin'),
('Victor Viquez', 'victorvh.vvh12@gmail.com', '$2y$12$/g7T3A8ZFQkDc0ZTd6Z2RehtLZRcpsifgs0KnFs.O51r.vNXZbe9y', 'admin'),
('Mesero Demo', 'mesero@correo.com', '$2y$12$/g7T3A8ZFQkDc0ZTd6Z2RehtLZRcpsifgs0KnFs.O51r.vNXZbe9y', 'mesero'),
('Prueba', 'prueba1@gmail.com', '$2y$12$/g7T3A8ZFQkDc0ZTd6Z2RehtLZRcpsifgs0KnFs.O51r.vNXZbe9y', 'mesero');

-- =====================================
-- MESAS SEED
-- =====================================
INSERT INTO mesas (numero_mesa, capacidad, estado) VALUES
(1, 4, 'disponible'),
(2, 2, 'disponible'),
(3, 6, 'ocupada'),
(4, 4, 'disponible');

-- =====================================
-- PRODUCTOS SEED
-- =====================================
INSERT INTO productos (nombre, descripcion, precio, estado) VALUES
('Hamburguesa', 'Hamburguesa especial de la casa', 3500.00, 'activo'),
('Pizza personal', 'Pizza personal de pepperoni', 4500.00, 'activo'),
('Refresco', 'Bebida gaseosa 600ml', 1200.00, 'activo'),
('Alitas', 'Porción de alitas picantes', 4000.00, 'activo');

-- =====================================
-- RESERVAS SEED
-- =====================================
INSERT INTO reservas (usuario_id, fecha, hora, personas, comentario, estado) VALUES
(2, '2026-04-23', '18:30:00', 2, 'Reserva de prueba para Victor', 'pendiente'),
(3, '2026-04-24', '19:00:00', 4, 'Mesa para clientes frecuentes', 'aprobada'),
(4, '2026-04-25', '20:00:00', 3, 'Cumpleaños pequeño', 'rechazada');

-- =====================================
-- PEDIDOS SEED
-- =====================================
INSERT INTO pedidos (mesa_id, usuario_id, estado, fecha, total) VALUES
(1, 2, 'activo', NOW(), 0.00),
(2, 3, 'cerrado', NOW(), 5900.00);

INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES
(2, 1, 1, 3500.00, 3500.00),
(2, 3, 1, 1200.00, 1200.00),
(2, 3, 1, 1200.00, 1200.00);

-- =====================================
-- PROCEDIMIENTOS ALMACENADOS
-- =====================================
DELIMITER $$

CREATE PROCEDURE sp_listar_reservas()
BEGIN
    SELECT 
        r.id,
        u.nombre,
        u.email,
        r.fecha,
        r.hora,
        r.personas,
        r.comentario,
        r.estado,
        r.creado_en
    FROM reservas r
    INNER JOIN usuarios u ON u.id = r.usuario_id
    ORDER BY r.fecha DESC, r.hora DESC;
END $$

CREATE PROCEDURE sp_insertar_reserva(
    IN p_usuario_id INT,
    IN p_fecha DATE,
    IN p_hora TIME,
    IN p_personas INT,
    IN p_comentario VARCHAR(255)
)
BEGIN
    INSERT INTO reservas (usuario_id, fecha, hora, personas, comentario)
    VALUES (p_usuario_id, p_fecha, p_hora, p_personas, p_comentario);
END $$

DELIMITER ;