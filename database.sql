
-- Bodegas
CREATE TABLE bodegas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Sucursales (Relacionada con Bodegas)
CREATE TABLE sucursales (
    id SERIAL PRIMARY KEY,
    bodega_id INTEGER NOT NULL REFERENCES bodegas(id),
    nombre VARCHAR(50) NOT NULL
);

-- Monedas
CREATE TABLE monedas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    simbolo VARCHAR(5) NOT NULL
);

-- Materiales
CREATE TABLE materiales (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(25) NOT NULL
);

-- ==========================================

-- Productos
CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(15) UNIQUE NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INTEGER NOT NULL REFERENCES bodegas(id),
    sucursal_id INTEGER NOT NULL REFERENCES sucursales(id),
    moneda_id INTEGER NOT NULL REFERENCES monedas(id),
    precio NUMERIC(10, 2) NOT NULL,
    descripcion VARCHAR(1000) NOT NULL,
);

-- ==========================================

-- Productos y Materiales
CREATE TABLE producto_materiales (
    producto_id INTEGER REFERENCES productos(id) ON DELETE CASCADE,
    material_id INTEGER REFERENCES materiales(id) ON DELETE CASCADE,
    PRIMARY KEY (producto_id, material_id)
);

-- ==========================================

-- Datos de ejemplo para poblar las tablas
INSERT INTO bodegas (nombre) VALUES 
('Bodega Norte'),
('Bodega Central'), 
('Bodega Sur');

INSERT INTO sucursales (bodega_id, nombre) VALUES 
(1, 'Sucursal Antofagasta'), 
(1, 'Sucursal Iquique')

(2, 'Sucursal Santiago'), 
(2, 'Sucursal Rancagua'),

(3, 'Sucursal Concepción'), 
(3, 'Sucursal Temuco');


INSERT INTO monedas (nombre, simbolo) VALUES 
('Peso Chileno', 'CLP'), 
('Dólar Estadounidense', 'USD'), 
('Euro', 'EUR');

INSERT INTO materiales (nombre) VALUES 
('Plástico'), 
('Metal'), 
('Madera'), 
('Vidrio'), 
('Textil');

