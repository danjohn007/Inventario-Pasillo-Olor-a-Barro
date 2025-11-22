-- Datos de ejemplo para Querétaro, México
USE inventario_artesanal;

-- Insertar roles
INSERT INTO roles (nombre, descripcion, permisos) VALUES
('Administrador', 'Control total del sistema', '{"usuarios": "all", "productos": "all", "ventas": "all", "inventario": "all", "reportes": "all", "configuracion": "all"}'),
('Gerente', 'Gestión de sucursal', '{"usuarios": "read", "productos": "all", "ventas": "all", "inventario": "all", "reportes": "read"}'),
('Vendedor', 'Ventas y atención al cliente', '{"productos": "read", "ventas": "create", "clientes": "all"}'),
('Almacenista', 'Control de inventario', '{"productos": "read", "inventario": "all", "transferencias": "all"}'),
('Artesano', 'Consulta de productos y órdenes', '{"productos": "read", "ordenes": "read"}');

-- Insertar usuario administrador (password: admin123)
INSERT INTO usuarios (username, email, password, nombre_completo, rol_id, telefono, activo) VALUES
('admin', 'admin@artesaniasqro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador del Sistema', 1, '4421234567', 1),
('gerente1', 'gerente.centro@artesaniasqro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'María González Pérez', 2, '4421234568', 1),
('vendedor1', 'ventas.centro@artesaniasqro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Juan Ramírez López', 3, '4421234569', 1);

-- Insertar sucursales en Querétaro
INSERT INTO sucursales (nombre, codigo, direccion, ciudad, estado, codigo_postal, telefono, email, activo) VALUES
('Sucursal Centro Histórico', 'QRO-CENTRO', 'Calle Andador 5 de Mayo #38, Centro Histórico', 'Santiago de Querétaro', 'Querétaro', '76000', '4422123456', 'centro@artesaniasqro.com', 1),
('Sucursal Plaza Constitución', 'QRO-CONST', 'Av. Constituyentes Poniente #180, El Jacal', 'Santiago de Querétaro', 'Querétaro', '76180', '4422123457', 'constitucion@artesaniasqro.com', 1),
('Sucursal Antea', 'QRO-ANTEA', 'Boulevard Antea #1001, Local 235', 'Santiago de Querétaro', 'Querétaro', '76226', '4422123458', 'antea@artesaniasqro.com', 1),
('Sucursal San Juan del Río', 'SJR-CENTRO', 'Calle Hidalgo #15, Centro', 'San Juan del Río', 'Querétaro', '76800', '4272123459', 'sjuanrio@artesaniasqro.com', 1);

-- Actualizar usuarios con sucursales
UPDATE usuarios SET sucursal_id = 1 WHERE username = 'gerente1';
UPDATE usuarios SET sucursal_id = 1 WHERE username = 'vendedor1';

-- Insertar artesanos/proveedores de Querétaro
INSERT INTO proveedores (nombre, tipo, region_origen, especialidad, telefono, email, direccion, activo) VALUES
('Taller Familiar Pérez', 'artesano', 'Amealco de Bonfil', 'Muñecas Otomíes y textiles', '4421111111', 'tallerpérez@gmail.com', 'Amealco de Bonfil, Querétaro', 1),
('Artesanías Don Miguel', 'artesano', 'Tequisquiapan', 'Cestería y mimbre', '4142222222', 'donmiguel@hotmail.com', 'Tequisquiapan, Querétaro', 1),
('Cerámica La Queretana', 'taller', 'Santiago de Querétaro', 'Cerámica y alfarería', '4423333333', 'ceramica.queretana@gmail.com', 'Querétaro, Querétaro', 1),
('Textiles Otomí Tradicional', 'artesano', 'Tolimán', 'Bordados y textiles otomíes', '4414444444', 'textiles.otomi@yahoo.com', 'Tolimán, Querétaro', 1),
('Taller de Ópalo Noble', 'taller', 'Tequisquiapan', 'Joyería con ópalo de fuego', '4145555555', 'opalo.noble@gmail.com', 'Tequisquiapan, Querétaro', 1);

-- Insertar categorías
INSERT INTO categorias (nombre, descripcion, icono, activo, orden) VALUES
('Textiles', 'Productos textiles artesanales', 'fabric', 1, 1),
('Cerámica', 'Piezas de cerámica y alfarería', 'pottery', 1, 2),
('Joyería', 'Joyería artesanal', 'jewelry', 1, 3),
('Cestería', 'Canastas y productos de mimbre', 'basket', 1, 4),
('Muñecas', 'Muñecas artesanales tradicionales', 'doll', 1, 5),
('Decoración', 'Artículos decorativos', 'decor', 1, 6);

-- Insertar productos típicos de Querétaro
INSERT INTO productos (sku, nombre, descripcion, categoria_id, proveedor_id, precio_compra, precio_venta, materiales, tecnica, region_origen, tiempo_elaboracion, edicion_limitada, requiere_certificado, activo) VALUES
('MUÑ-OTOMI-001', 'Muñeca Otomí Grande', 'Muñeca tradicional otomí hecha a mano con textiles bordados', 5, 1, 350.00, 650.00, 'Tela de algodón, hilos de colores, relleno natural', 'Bordado tradicional otomí', 'Amealco de Bonfil, Qro', '15-20 días', 0, 1, 1),
('MUÑ-OTOMI-002', 'Muñeca Otomí Mediana', 'Muñeca tradicional otomí tamaño mediano', 5, 1, 200.00, 400.00, 'Tela de algodón, hilos de colores, relleno natural', 'Bordado tradicional otomí', 'Amealco de Bonfil, Qro', '10-15 días', 0, 1, 1),
('CEST-MIM-001', 'Canasta Grande de Mimbre', 'Canasta artesanal de mimbre natural', 4, 2, 180.00, 380.00, 'Mimbre natural', 'Tejido tradicional', 'Tequisquiapan, Qro', '7-10 días', 0, 0, 1),
('CEST-MIM-002', 'Set 3 Canastas Decorativas', 'Juego de 3 canastas de diferentes tamaños', 4, 2, 250.00, 520.00, 'Mimbre natural', 'Tejido tradicional', 'Tequisquiapan, Qro', '10-12 días', 0, 0, 1),
('CER-JARR-001', 'Jarrón de Cerámica Mediano', 'Jarrón decorativo de cerámica pintado a mano', 2, 3, 120.00, 280.00, 'Barro cocido, esmaltes naturales', 'Alfarería tradicional', 'Santiago de Querétaro', '5-7 días', 0, 0, 1),
('CER-TAZA-001', 'Juego 6 Tazas Artesanales', 'Set de 6 tazas de cerámica con diseños únicos', 2, 3, 200.00, 450.00, 'Barro cocido, esmaltes naturales', 'Alfarería tradicional', 'Santiago de Querétaro', '8-10 días', 0, 0, 1),
('TEXT-MANT-001', 'Mantel Bordado Otomí', 'Mantel rectangular con bordado tradicional otomí', 1, 4, 450.00, 890.00, 'Tela de algodón, hilos de colores', 'Bordado manual otomí', 'Tolimán, Qro', '20-25 días', 0, 1, 1),
('TEXT-COJIN-001', 'Cojín Bordado Otomí', 'Cojín decorativo con bordado otomí', 1, 4, 180.00, 350.00, 'Tela de algodón, hilos de colores, relleno', 'Bordado manual otomí', 'Tolimán, Qro', '8-10 días', 0, 0, 1),
('JOY-COLLAR-001', 'Collar Ópalo de Fuego', 'Collar con ópalo de fuego natural de Querétaro', 3, 5, 1200.00, 2500.00, 'Ópalo de fuego, plata .925', 'Joyería artesanal', 'Tequisquiapan, Qro', '5-7 días', 1, 1, 1),
('JOY-ARETES-001', 'Aretes Ópalo de Fuego', 'Par de aretes con ópalo de fuego', 3, 5, 800.00, 1800.00, 'Ópalo de fuego, plata .925', 'Joyería artesanal', 'Tequisquiapan, Qro', '3-5 días', 1, 1, 1);

-- Insertar variantes de productos
INSERT INTO producto_variantes (producto_id, nombre, atributo, valor, precio_adicional, sku_variante) VALUES
(1, 'Muñeca Otomí Grande - Rojo', 'color', 'Rojo', 0, 'MUÑ-OTOMI-001-ROJO'),
(1, 'Muñeca Otomí Grande - Azul', 'color', 'Azul', 0, 'MUÑ-OTOMI-001-AZUL'),
(1, 'Muñeca Otomí Grande - Verde', 'color', 'Verde', 0, 'MUÑ-OTOMI-001-VERDE'),
(2, 'Muñeca Otomí Mediana - Rojo', 'color', 'Rojo', 0, 'MUÑ-OTOMI-002-ROJO'),
(2, 'Muñeca Otomí Mediana - Azul', 'color', 'Azul', 0, 'MUÑ-OTOMI-002-AZUL'),
(7, 'Mantel Bordado 1.5x2m', 'tamaño', '1.5x2 metros', 0, 'TEXT-MANT-001-150'),
(7, 'Mantel Bordado 2x2.5m', 'tamaño', '2x2.5 metros', 200, 'TEXT-MANT-001-200');

-- Insertar inventario inicial en sucursales
INSERT INTO inventario (producto_id, variante_id, sucursal_id, cantidad, ubicacion_fisica, stock_minimo, stock_maximo) VALUES
-- Sucursal Centro Histórico
(1, 1, 1, 15, 'Estante A1', 3, 30),
(1, 2, 1, 12, 'Estante A1', 3, 30),
(1, 3, 1, 10, 'Estante A1', 3, 30),
(2, 4, 1, 20, 'Estante A2', 5, 40),
(2, 5, 1, 18, 'Estante A2', 5, 40),
(3, NULL, 1, 8, 'Estante B1', 2, 15),
(4, NULL, 1, 12, 'Estante B1', 3, 20),
(5, NULL, 1, 15, 'Vitrina C1', 4, 25),
(6, NULL, 1, 10, 'Vitrina C2', 3, 20),
(7, 6, 1, 5, 'Estante D1', 2, 10),
(7, 7, 1, 3, 'Estante D1', 1, 8),
(8, NULL, 1, 25, 'Estante D2', 5, 40),
(9, NULL, 1, 4, 'Vitrina Especial', 1, 8),
(10, NULL, 1, 6, 'Vitrina Especial', 2, 10),
-- Sucursal Plaza Constitución
(1, 1, 2, 10, 'Zona A', 3, 25),
(2, 4, 2, 15, 'Zona A', 4, 30),
(3, NULL, 2, 6, 'Zona B', 2, 12),
(5, NULL, 2, 12, 'Zona C', 3, 20),
(8, NULL, 2, 18, 'Zona D', 4, 35),
-- Sucursal Antea
(1, 1, 3, 8, 'Área Textiles', 2, 20),
(3, NULL, 3, 10, 'Área Cestería', 3, 18),
(9, NULL, 3, 5, 'Joyería', 1, 10),
(10, NULL, 3, 7, 'Joyería', 2, 12);

-- Insertar clientes
INSERT INTO clientes (nombre, email, telefono, ciudad, estado, puntos_fidelidad, nivel_fidelidad) VALUES
('Ana María Torres', 'ana.torres@email.com', '4421111111', 'Santiago de Querétaro', 'Querétaro', 150, 'plata'),
('Roberto Sánchez', 'roberto.sanchez@email.com', '4422222222', 'Santiago de Querétaro', 'Querétaro', 80, 'bronce'),
('Laura Mendoza', 'laura.mendoza@email.com', '4423333333', 'San Juan del Río', 'Querétaro', 250, 'oro'),
('Carlos Jiménez', 'carlos.jimenez@email.com', '4424444444', 'Santiago de Querétaro', 'Querétaro', 45, 'bronce');

-- Insertar configuración del sistema
INSERT INTO configuracion (clave, valor, tipo, categoria, descripcion) VALUES
('sitio_nombre', 'Artesanías de Querétaro', 'texto', 'general', 'Nombre del sitio'),
('sitio_logo', '', 'archivo', 'general', 'Logo del sitio'),
('color_primario', '#8B4513', 'color', 'apariencia', 'Color primario del tema'),
('color_secundario', '#D2691E', 'color', 'apariencia', 'Color secundario del tema'),
('iva_porcentaje', '16', 'numero', 'ventas', 'Porcentaje de IVA'),
('puntos_por_peso', '1', 'numero', 'fidelidad', 'Puntos otorgados por cada peso gastado'),
('email_remitente', 'noreply@artesaniasqro.com', 'email', 'email', 'Email remitente del sistema'),
('email_smtp_host', '', 'texto', 'email', 'Servidor SMTP'),
('email_smtp_port', '587', 'numero', 'email', 'Puerto SMTP'),
('paypal_client_id', '', 'texto', 'pagos', 'PayPal Client ID'),
('paypal_modo', 'sandbox', 'texto', 'pagos', 'Modo PayPal (sandbox/live)'),
('qr_api_key', '', 'texto', 'integracion', 'API Key para generación de códigos QR');

-- Insertar ventas de ejemplo
INSERT INTO ventas (numero_venta, sucursal_id, cliente_id, usuario_id, fecha_venta, subtotal, descuento, iva, total, metodo_pago, puntos_otorgados) VALUES
('VTA-2024-0001', 1, 1, 3, '2024-11-20 10:30:00', 1030.00, 0, 164.80, 1194.80, 'tarjeta', 11),
('VTA-2024-0002', 1, 2, 3, '2024-11-20 14:45:00', 650.00, 0, 104.00, 754.00, 'efectivo', 7),
('VTA-2024-0003', 1, 3, 3, '2024-11-21 11:20:00', 2880.00, 0, 460.80, 3340.80, 'tarjeta', 33);

-- Insertar detalle de ventas
INSERT INTO venta_detalles (venta_id, producto_id, variante_id, cantidad, precio_unitario, subtotal) VALUES
(1, 8, NULL, 2, 350.00, 700.00),
(1, 5, NULL, 1, 280.00, 280.00),
(1, 10, NULL, 1, 1800.00, 1800.00),
(2, 1, 1, 1, 650.00, 650.00),
(3, 7, 6, 1, 890.00, 890.00),
(3, 9, NULL, 1, 2500.00, 2500.00);

-- Insertar orden de compra ejemplo
INSERT INTO ordenes_compra (numero_orden, proveedor_id, sucursal_id, usuario_id, fecha_orden, fecha_esperada, estado, subtotal, iva, total) VALUES
('OC-2024-0001', 1, 1, 2, '2024-11-15', '2024-12-01', 'en_produccion', 5500.00, 880.00, 6380.00);

-- Insertar detalle de orden de compra
INSERT INTO orden_compra_detalles (orden_id, producto_id, variante_id, cantidad, precio_unitario, subtotal) VALUES
(1, 1, 1, 5, 350.00, 1750.00),
(1, 1, 2, 5, 350.00, 1750.00),
(1, 2, 4, 10, 200.00, 2000.00);
