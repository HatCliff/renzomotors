
CREATE TABLE marcas (
    id_marca int AUTO_INCREMENT PRIMARY KEY,
    nombre_marca varchar(100) NOT NULL,
    descripcion text,
    logo varchar(200) NOT NULL
);
CREATE TABLE anios (
    id_anio int AUTO_INCREMENT PRIMARY KEY,
    anio int NOT NULL
);
CREATE TABLE tipo_vehiculo (
    id_tipo_vehiculo int AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo_vehiculo varchar(100) NOT NULL
);
CREATE TABLE transmisiones (
    id_transmision int AUTO_INCREMENT PRIMARY KEY,
    nombre_transmision varchar(100) NOT NULL
);
CREATE TABLE tipo_combustible (
    id_tipo_combustible int AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo_combustible varchar(100) NOT NULL
);
CREATE TABLE paises (
    id_pais int AUTO_INCREMENT PRIMARY KEY,
    nombre_pais varchar(100) NOT NULL
);
CREATE TABLE tipos_accesorios (
    id_tipo_accesorio INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo_accesorio VARCHAR(100) NOT NULL
);

CREATE TABLE accesorios (
    sku INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio INT NOT NULL,
    stock INT NOT NULL,
    descripcion TEXT,
    foto VARCHAR(255)
);

CREATE TABLE accesorio_tipo (
    id_accesorio_tipo INT AUTO_INCREMENT PRIMARY KEY,
    sku_accesorio INT,
    id_tipo_accesorio INT,
    FOREIGN KEY (sku_accesorio) REFERENCES accesorios(sku),
    FOREIGN KEY (id_tipo_accesorio) REFERENCES tipos_accesorios(id_tipo_accesorio)
);

CREATE TABLE fotos_accesorio (
    id_foto INT AUTO_INCREMENT PRIMARY KEY,
    sku_accesorio INT,
    foto VARCHAR(255) NOT NULL,
    FOREIGN KEY (sku_accesorio) REFERENCES accesorios(sku) ON DELETE CASCADE
);
CREATE TABLE proveedores_seguro (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre_proveedor VARCHAR(100) NOT NULL
);

CREATE TABLE tipo_cobertura (
    id_tipo_cobertura INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo_cobertura VARCHAR(100) NOT NULL
);

CREATE TABLE seguros (
    id_seguro INT AUTO_INCREMENT PRIMARY KEY,
    nombre_seguro VARCHAR(100) NOT NULL,
    descripcion TEXT,
    id_proveedor INT,
    id_tipo_cobertura INT,
    precio INT NOT NULL,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores_seguro(id_proveedor),
    FOREIGN KEY (id_tipo_cobertura) REFERENCES tipo_cobertura(id_tipo_cobertura)
);
CREATE TABLE colores (
    id_color int AUTO_INCREMENT PRIMARY KEY,
    nombre_color varchar(100) NOT NULL,
    codigo_color VARCHAR(7) NOT NULL
);



CREATE TABLE tipos_pago (
    id_tipo_pago INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(255) NOT NULL
);
CREATE TABLE permisos (
    id_permiso INT AUTO_INCREMENT PRIMARY KEY,
    nombre_permiso VARCHAR(255) NOT NULL
);
CREATE TABLE roles_permisos (
    id_rol INT,
    id_permiso INT,
    PRIMARY KEY (id_rol, id_permiso),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
    FOREIGN KEY (id_permiso) REFERENCES permisos(id_permiso)
);


CREATE TABLE financiamiento (
    id_financiamiento int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(100) NOT NULL,
    tasa_interes float NOT NULL,
    plazo_maximo varchar(50) NOT NULL,
    requisitos text
);
CREATE TABLE vehiculos (
    id_vehiculo int AUTO_INCREMENT PRIMARY KEY,
    nombre_modelo varchar(100) NOT NULL,
    id_marca int,
    id_anio int,
    precio INT NOT NULL,
    id_tipo_vehiculo int,
    id_transmision int,
    id_tipo_combustible int,
    estado VARCHAR(10),
    id_pais int,
    FOREIGN KEY (id_marca) REFERENCES marcas(id_marca),
    FOREIGN KEY (id_anio) REFERENCES anios(id_anio),
    FOREIGN KEY (id_tipo_vehiculo) REFERENCES tipo_vehiculo(id_tipo_vehiculo),
    FOREIGN KEY (id_transmision) REFERENCES transmisiones(id_transmision),
    FOREIGN KEY (id_tipo_combustible) REFERENCES tipo_combustible(id_tipo_combustible),
    FOREIGN KEY (id_pais) REFERENCES paises(id_pais)
);
CREATE TABLE vehiculo_colores (
    id_vehiculo int,
    id_color int,
    PRIMARY KEY (id_vehiculo, id_color),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
    FOREIGN KEY (id_color) REFERENCES colores(id_color)
);
CREATE TABLE fotos_vehiculos (
    id_foto INT AUTO_INCREMENT PRIMARY KEY,
    id_vehiculo INT NOT NULL,
    ruta_foto VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo)
        ON DELETE CASCADE
);
CREATE TABLE sucursales (
    id_sucursal int(11) NOT NULL AUTO_INCREMENT,
    nombre_sucursal varchar(100) NOT NULL,
    encargado_sucursal varchar(100) NOT NULL,
    direccion_sucursal varchar(200),
    PRIMARY KEY (id_sucursal)
);


CREATE TABLE servicios (
    id_servicio int(11) NOT NULL AUTO_INCREMENT,
    nombre_servicio varchar(100) NOT NULL,
    descripcion text,
    precio_servicio int(11),
    PRIMARY KEY (id_servicio)
);


CREATE TABLE servicio_sucursal (
    id_servicio int(11) NOT NULL,
    id_sucursal int(11) NOT NULL,
    PRIMARY KEY (id_servicio, id_sucursal),
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio),
    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id_sucursal)
);