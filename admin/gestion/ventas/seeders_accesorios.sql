-- Tabla: usuario_registrado
INSERT INTO usuario_registrado (rut, nombre, apellido, correo, contrasenia, tipo_persona) VALUES
('12345678-9', 'Juan', 'Perez', 'juan.perez@example.com', '$2a$10$X8O9vHJJe5KYFJ/8JLKUhuGEA0C9RwtCSjKgkwUPv8Oi9P5Llf71u', 'usuario'),
('87654321-0', 'Maria', 'Lopez', 'maria.lopez@example.com', '$2a$10$Q6fXJ8Qjd3n/OdY8ZkF/UuaPQAIENsyRnOElFZhdv8Gl9ZOr9YZ6G', 'usuario'),
('11223344-5', 'Pedro', 'Gomez', 'pedro.gomez@example.com', '$2a$10$L1Q9XXsGzUOqKjZ2Qd9.ZeWt7Y17eUCSdoHMYRFPuvfYXYF5Wr08a', 'usuario'),
('99887766-3', 'Laura', 'Martinez', 'laura.martinez@example.com', '$2a$10$9fOIJdLXAcvuwMlRQ68yRuT9ox.2VrPfIGzOjFKn3F/OVuE1KH9pq', 'usuario'),
('44556677-8', 'Diego', 'Fuentes', 'diego.fuentes@example.com', '$2a$10$MY8JKmFY98XFKvWqj.0mP.Z73NFEDUZy2qsPpl0P8c0uF7YI8PqB6', 'usuario'),
('12312312-1', 'Ana', 'Rojas', 'ana.rojas@example.com', '$2a$10$79FWvY/9sGmUCR9QhLpYxuQK2MtspxRWK9.FCKIRX3tUnMI6OtDlm', 'usuario'),
('32132132-2', 'Jorge', 'Silva', 'jorge.silva@example.com', '$2a$10$Lqs8IvDm.pH41qjZqD.druTnUC9sUVIZt4LJ/W28xLzx38aHYD5K2', 'usuario'),
('99988877-6', 'Camila', 'Vega', 'camila.vega@example.com', '$2a$10$XtGRFuhr3dqlpWBKJbCv1.fu26KhDwvU8AfVRZ0oJmT0ogGS6EZe2', 'usuario'),
('54321678-9', 'Luis', 'Castro', 'luis.castro@example.com', '$2a$10$NQJU6D76P/kU5WBXx63QkeR76hK/FdFgUXRp5BNIlFT4uSx5TiMtG', 'usuario'),
('22334455-4', 'Isabel', 'Mendez', 'isabel.mendez@example.com', '$2a$10$xFbfzUnIM6frOu/13pA6bOxZIC3zLr6ZPuq6FIcsgg9xMNfR9PvhW', 'usuario'),
('55667788-1', 'Tomas', 'Pena', 'tomas.pena@example.com', '$2a$10$gNE8Q7PDPTOcPphBQEOmL.9OB5vcW3j.yPMXlYZ91CF6OT27u5Aa6', 'usuario'),
('66778899-2', 'Sara', 'Ortega', 'sara.ortega@example.com', '$2a$10$.GVYB2A2ksH4uPy39qRC4.5weQcfbMjShB/TMIsHFxsW4mofJqeym', 'usuario'),
('12332145-6', 'Carlos', 'Navarro', 'carlos.navarro@example.com', '$2a$10$zUgDweQoqc2RbSYGyZTFNO/Hmlt1uWo8FUy.I9sGcTXgFWcP5Va7a', 'usuario'),
('43214321-0', 'Daniela', 'Salas', 'daniela.salas@example.com', '$2a$10$JdHNs6O8nE4WKH.U21Rj9OX1Vi1BcAzhmyKw0.SAZHVE6jtE3HyPG', 'usuario'),
('87656789-0', 'Ignacio', 'Paredes', 'ignacio.paredes@example.com', '$2a$10$A2OQ6Y7HFlXplEwZR5AuAeLfIAsNl5lC1ZcmR/5WHUwBhRP5l1IFK', 'usuario');

-- Tabla: carrito_usuario
INSERT INTO carrito_usuario (id_carrito, rut_usuario, valor_carrito) VALUES
(3, '12345678-9', 35000),
(4, '87654321-0', 45000),
(5, '11223344-5', 12000),
(6, '99887766-3', 55000),
(7, '44556677-8', 67000),
(8, '12312312-1', 31000),
(9, '32132132-2', 80000),
(10, '99988877-6', 22000),
(11, '54321678-9', 43000),
(12, '22334455-4', 50000),
(13, '55667788-1', 29000),
(14, '66778899-2', 63000),
(15, '12332145-6', 47000),
(16, '43214321-0', 51000),
(17, '87656789-0', 60000);

-- Tabla: registro_accesorio
INSERT INTO registro_accesorio (codigo_verificador, sucursal_compra, correo_compra, fecha_compra_a, listado_compra, valor_compra, id_carrito) VALUES
('234556', 'Santiago', 'juan.perez@example.com', '2024-11-30', 'Accesorio1, Accesorio2', 35000, 1),
('123555', 'Valparaiso', 'maria.lopez@example.com', '2024-11-29', 'Accesorio3', 45000, 2),
('654784', 'Concepcion', 'pedro.gomez@example.com', '2024-11-28', 'Accesorio4, Accesorio5', 12000, 3),
('547853', 'Santiago', 'laura.martinez@example.com', '2024-11-27', 'Accesorio6', 55000, 4),
('123891', 'Temuco', 'diego.fuentes@example.com', '2024-11-26', 'Accesorio7', 67000, 5),
('521893', 'Rancagua', 'ana.rojas@example.com', '2024-11-25', 'Accesorio8', 31000, 6),
('578291', 'Iquique', 'jorge.silva@example.com', '2024-11-24', 'Accesorio9', 80000, 7),
('583990', 'La Serena', 'camila.vega@example.com', '2024-11-23', 'Accesorio10, Accesorio11', 22000, 8),
('382194', 'Antofagasta', 'luis.castro@example.com', '2024-11-22', 'Accesorio12', 43000, 9),
('284927', 'Santiago', 'isabel.mendez@example.com', '2024-11-21', 'Accesorio13', 50000, 10),
('237829', 'Valdivia', 'tomas.pena@example.com', '2024-11-20', 'Accesorio14', 29000, 11),
('853929', 'Chillan', 'sara.ortega@example.com', '2024-11-19', 'Accesorio15', 63000, 12),
('783294', 'Puerto Montt', 'carlos.navarro@example.com', '2024-11-18', 'Accesorio16', 47000, 13),
('328745', 'Osorno', 'daniela.salas@example.com', '2024-11-17', 'Accesorio17', 51000, 14),
('578489', 'Arica', 'ignacio.paredes@example.com', '2024-11-16', 'Accesorio18', 60000, 15);
