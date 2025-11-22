# Sistema de Inventario Multisucursal para Productos Artesanales

Sistema completo de gestión de inventarios diseñado específicamente para negocios de productos artesanales con múltiples sucursales en Querétaro, México.

## 🎨 Características Principales

### Gestión de Productos Artesanales
- ✅ Catálogo completo con atributos específicos para artesanías
- ✅ Información detallada: materiales, técnicas, artesano, región de origen
- ✅ Gestión de variantes (colores, tamaños, diseños)
- ✅ Soporte para múltiples fotos por producto
- ✅ Control de productos de edición limitada
- ✅ Certificados de autenticidad

### Sistema Multisucursal
- ✅ Gestión completa de sucursales
- ✅ Transferencias entre sucursales
- ✅ Inventario independiente por sucursal
- ✅ Seguimiento en tiempo real

### Control de Inventario
- ✅ Stock por sucursal y producto
- ✅ Alertas de stock bajo
- ✅ Movimientos de inventario (entradas/salidas/ajustes)
- ✅ Historial completo de movimientos
- ✅ Ubicación física dentro de la sucursal

### Ventas y Punto de Venta
- ✅ Módulo POS (Punto de Venta)
- ✅ Múltiples métodos de pago
- ✅ Gestión de clientes y programa de fidelización
- ✅ Historial de ventas

### Compras y Proveedores
- ✅ Gestión de artesanos y proveedores
- ✅ Órdenes de compra/producción
- ✅ Seguimiento de pedidos

### Reportes y Analytics
- ✅ Reportes de inventario y ventas
- ✅ Gráficas interactivas con Chart.js
- ✅ Análisis por sucursal
- ✅ Productos más vendidos

### Gestión de Usuarios
- ✅ Sistema de roles y permisos
- ✅ Roles: Administrador, Gerente, Vendedor, Almacenista, Artesano
- ✅ Autenticación segura con password_hash()

### Módulo de Configuración
- ✅ Configuración del sitio (nombre, logo)
- ✅ Configuración de email
- ✅ Personalización de colores
- ✅ Integración con PayPal
- ✅ API para códigos QR

## 🚀 Tecnologías Utilizadas

- **Backend:** PHP puro (sin framework)
- **Base de datos:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **Estilos:** Tailwind CSS (diseño responsivo y minimalista)
- **Gráficas:** Chart.js
- **Calendario:** FullCalendar.js
- **Arquitectura:** MVC (Modelo-Vista-Controlador)
- **Seguridad:** password_hash() para encriptación de contraseñas

## 📋 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor Apache con mod_rewrite habilitado
- Extensiones PHP requeridas:
  - PDO
  - PDO_MySQL
  - JSON
  - Session

## 🔧 Instalación

### Paso 1: Clonar o descargar el repositorio

```bash
git clone https://github.com/danjohn007/Inventario-Pasillo-Olor-a-Barro.git
cd Inventario-Pasillo-Olor-a-Barro
```

### Paso 2: Configurar el servidor Apache

Puedes instalar el sistema en cualquier directorio de tu servidor Apache. El sistema detecta automáticamente la URL base.

**Opción A: En el directorio raíz**
```
/var/www/html/
```

**Opción B: En un subdirectorio**
```
/var/www/html/inventario/
```

### Paso 3: Crear la base de datos

1. Accede a tu gestor MySQL (phpMyAdmin, MySQL Workbench, o línea de comandos)

2. Crea la base de datos ejecutando:
```sql
CREATE DATABASE inventario_artesanal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Importa el esquema de la base de datos:
```bash
mysql -u root -p inventario_artesanal < assets/sql/schema.sql
```

4. Importa los datos de ejemplo:
```bash
mysql -u root -p inventario_artesanal < assets/sql/datos_ejemplo.sql
```

### Paso 4: Configurar las credenciales de la base de datos

Edita el archivo `config/config.php` y actualiza las credenciales de tu base de datos:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'inventario_artesanal');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
```

### Paso 5: Configurar permisos

Asegúrate de que el directorio `public/uploads/` tenga permisos de escritura:

```bash
chmod -R 755 public/uploads/
```

### Paso 6: Probar la instalación

Accede al archivo de test en tu navegador:

```
http://tu-dominio.com/test_conexion.php
```

o si está en un subdirectorio:

```
http://tu-dominio.com/inventario/test_conexion.php
```

Este archivo verificará:
- ✅ Configuración básica
- ✅ Auto-detección de URL base
- ✅ Conexión a la base de datos
- ✅ Existencia de tablas
- ✅ Sesiones PHP
- ✅ Permisos de escritura
- ✅ Versión de PHP

## 🔐 Credenciales de Acceso

### Usuario Administrador
- **Usuario:** admin
- **Contraseña:** admin123

### Usuario Gerente
- **Usuario:** gerente1
- **Contraseña:** admin123

### Usuario Vendedor
- **Usuario:** vendedor1
- **Contraseña:** admin123

**⚠️ IMPORTANTE:** Cambia estas contraseñas después de la primera sesión en producción.

## 📁 Estructura del Proyecto

```
inventario-artesanal/
├── app/
│   ├── controllers/      # Controladores MVC
│   │   ├── BaseController.php
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── ProductosController.php
│   │   ├── SucursalesController.php
│   │   ├── InventarioController.php
│   │   ├── VentasController.php
│   │   ├── ComprasController.php
│   │   ├── ReportesController.php
│   │   └── UsuariosController.php
│   ├── models/           # Modelos de datos
│   │   └── BaseModel.php
│   └── views/            # Vistas (HTML/PHP)
│       ├── layouts/
│       ├── productos/
│       ├── sucursales/
│       ├── inventario/
│       ├── ventas/
│       ├── compras/
│       ├── reportes/
│       └── usuarios/
├── assets/
│   └── sql/              # Scripts SQL
│       ├── schema.sql
│       └── datos_ejemplo.sql
├── config/               # Configuración
│   ├── config.php
│   └── database.php
├── public/               # Punto de entrada público
│   ├── index.php
│   ├── .htaccess
│   ├── css/
│   ├── js/
│   ├── img/
│   └── uploads/
├── test_conexion.php     # Test de conexión
└── README.md
```

## 🌐 URLs Amigables

El sistema utiliza URLs amigables mediante mod_rewrite de Apache:

```
http://tu-dominio.com/
http://tu-dominio.com/productos
http://tu-dominio.com/productos/crear
http://tu-dominio.com/productos/editar/123
http://tu-dominio.com/sucursales
http://tu-dominio.com/inventario
http://tu-dominio.com/ventas
http://tu-dominio.com/reportes
```

## 🔄 URL Base Automática

El sistema detecta automáticamente la URL base, por lo que funciona en:
- Directorio raíz: `http://localhost/`
- Subdirectorio: `http://localhost/inventario/`
- Dominio: `http://midominio.com/`

No necesitas configurar manualmente la URL base.

## 🎯 Datos de Ejemplo - Querétaro

El sistema incluye datos de ejemplo específicos de Querétaro:

### Sucursales
- Sucursal Centro Histórico (Andador 5 de Mayo)
- Sucursal Plaza Constitución
- Sucursal Antea
- Sucursal San Juan del Río

### Artesanos/Proveedores
- Taller Familiar Pérez (Amealco - Muñecas Otomíes)
- Artesanías Don Miguel (Tequisquiapan - Cestería)
- Cerámica La Queretana (Querétaro - Cerámica)
- Textiles Otomí Tradicional (Tolimán - Bordados)
- Taller de Ópalo Noble (Tequisquiapan - Joyería)

### Productos
- Muñecas Otomíes
- Cestería de Mimbre
- Cerámica y Alfarería
- Textiles Bordados
- Joyería con Ópalo de Fuego

## 🛠 Solución de Problemas

### Error: "Cannot connect to database"
- Verifica las credenciales en `config/config.php`
- Asegúrate de que MySQL esté corriendo
- Verifica que la base de datos existe

### Error 404 en todas las páginas
- Verifica que mod_rewrite esté habilitado en Apache
- Verifica que el archivo `.htaccess` existe en `public/`
- Revisa la configuración de Apache para AllowOverride

### Error: "Permission denied" en uploads
```bash
chmod -R 755 public/uploads/
chown -R www-data:www-data public/uploads/
```

## 📝 Desarrollo Futuro

Módulos planificados para futuras versiones:
- Integración con pasarelas de pago (PayPal, Stripe)
- API REST para integraciones externas
- Aplicación móvil
- Sistema de notificaciones por email/SMS
- Módulo de facturación electrónica (CFDI)

## 👥 Roles y Permisos

| Rol | Permisos |
|-----|----------|
| Administrador | Acceso completo a todo el sistema |
| Gerente | Gestión de sucursal, productos, ventas, inventario |
| Vendedor | Crear ventas, consultar productos y clientes |
| Almacenista | Gestión de inventario y transferencias |
| Artesano | Consulta de productos y órdenes |

## 📞 Soporte

Para soporte y consultas:
- **Email:** soporte@artesaniasqro.com
- **Sitio web:** [En construcción]

## 📄 Licencia

Este proyecto es software privado desarrollado para fines específicos.

## 🙏 Agradecimientos

Desarrollado para apoyar a los artesanos de Querétaro, México.

---

**Versión:** 1.0.0  
**Última actualización:** Noviembre 2024
