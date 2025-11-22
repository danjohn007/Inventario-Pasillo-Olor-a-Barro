<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';
require_once ROOT_PATH . 'app/models/ProductoModel.php';
require_once ROOT_PATH . 'app/models/CategoriaModel.php';
require_once ROOT_PATH . 'app/models/ProveedorModel.php';

class ProductosController extends BaseController {
    
    private $productoModel;
    private $categoriaModel;
    private $proveedorModel;
    
    public function __construct() {
        parent::__construct();
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->proveedorModel = new ProveedorModel();
    }
    
    public function index() {
        $this->requireAuth();
        
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $productos = $this->productoModel->searchProductos($search);
        } else {
            $productos = $this->productoModel->getAllWithDetails();
        }
        
        $categorias = $this->categoriaModel->getAllWithCount();
        
        $this->view('productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'search' => $search
        ]);
    }
    
    public function ver($id) {
        $this->requireAuth();
        
        $producto = $this->productoModel->getByIdWithDetails($id);
        
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado';
            $this->redirect('productos');
        }
        
        $variantes = $this->productoModel->getVariantes($id);
        $fotos = $this->productoModel->getFotos($id);
        $certificado = $this->productoModel->getCertificado($id);
        $stock_total = $this->productoModel->getStockTotal($id);
        
        // Obtener stock por sucursal
        $stmt = $this->db->prepare("SELECT i.*, s.nombre as sucursal_nombre, s.codigo as sucursal_codigo
                                     FROM inventario i
                                     JOIN sucursales s ON i.sucursal_id = s.id
                                     WHERE i.producto_id = ?
                                     ORDER BY s.nombre");
        $stmt->execute([$id]);
        $stock_sucursales = $stmt->fetchAll();
        
        $this->view('productos/ver', [
            'producto' => $producto,
            'variantes' => $variantes,
            'fotos' => $fotos,
            'certificado' => $certificado,
            'stock_total' => $stock_total,
            'stock_sucursales' => $stock_sucursales
        ]);
    }
    
    public function crear() {
        $this->requireRole(['Administrador', 'Gerente']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos
            $sku = trim($_POST['sku'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $precio_compra = floatval($_POST['precio_compra'] ?? 0);
            $precio_venta = floatval($_POST['precio_venta'] ?? 0);
            
            // Validaciones
            if (empty($sku) || empty($nombre)) {
                $_SESSION['error'] = 'SKU y nombre son obligatorios';
            } elseif ($this->productoModel->skuExists($sku)) {
                $_SESSION['error'] = 'El SKU ya existe';
            } elseif ($precio_compra <= 0 || $precio_venta <= 0) {
                $_SESSION['error'] = 'Los precios deben ser mayores a cero';
            } else {
                // Crear producto
                $data = [
                    'sku' => $sku,
                    'nombre' => $nombre,
                    'descripcion' => trim($_POST['descripcion'] ?? ''),
                    'categoria_id' => !empty($_POST['categoria_id']) ? intval($_POST['categoria_id']) : null,
                    'proveedor_id' => !empty($_POST['proveedor_id']) ? intval($_POST['proveedor_id']) : null,
                    'precio_compra' => $precio_compra,
                    'precio_venta' => $precio_venta,
                    'materiales' => trim($_POST['materiales'] ?? ''),
                    'tecnica' => trim($_POST['tecnica'] ?? ''),
                    'region_origen' => trim($_POST['region_origen'] ?? ''),
                    'tiempo_elaboracion' => trim($_POST['tiempo_elaboracion'] ?? ''),
                    'edicion_limitada' => isset($_POST['edicion_limitada']) ? 1 : 0,
                    'unidades_limitadas' => !empty($_POST['unidades_limitadas']) ? intval($_POST['unidades_limitadas']) : null,
                    'requiere_certificado' => isset($_POST['requiere_certificado']) ? 1 : 0,
                    'peso' => !empty($_POST['peso']) ? floatval($_POST['peso']) : null,
                    'dimensiones' => trim($_POST['dimensiones'] ?? ''),
                    'activo' => 1
                ];
                
                $id = $this->productoModel->create($data);
                
                if ($id) {
                    $_SESSION['success'] = 'Producto creado exitosamente';
                    $this->redirect('productos/ver/' . $id);
                } else {
                    $_SESSION['error'] = 'Error al crear el producto';
                }
            }
        }
        
        $categorias = $this->categoriaModel->getAllActive();
        $proveedores = $this->proveedorModel->getAllActive();
        
        $this->view('productos/crear', [
            'categorias' => $categorias,
            'proveedores' => $proveedores
        ]);
    }
    
    public function editar($id) {
        $this->requireRole(['Administrador', 'Gerente']);
        
        $producto = $this->productoModel->getById($id);
        
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado';
            $this->redirect('productos');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sku = trim($_POST['sku'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $precio_compra = floatval($_POST['precio_compra'] ?? 0);
            $precio_venta = floatval($_POST['precio_venta'] ?? 0);
            
            if (empty($sku) || empty($nombre)) {
                $_SESSION['error'] = 'SKU y nombre son obligatorios';
            } elseif ($this->productoModel->skuExists($sku, $id)) {
                $_SESSION['error'] = 'El SKU ya existe';
            } elseif ($precio_compra <= 0 || $precio_venta <= 0) {
                $_SESSION['error'] = 'Los precios deben ser mayores a cero';
            } else {
                $data = [
                    'sku' => $sku,
                    'nombre' => $nombre,
                    'descripcion' => trim($_POST['descripcion'] ?? ''),
                    'categoria_id' => !empty($_POST['categoria_id']) ? intval($_POST['categoria_id']) : null,
                    'proveedor_id' => !empty($_POST['proveedor_id']) ? intval($_POST['proveedor_id']) : null,
                    'precio_compra' => $precio_compra,
                    'precio_venta' => $precio_venta,
                    'materiales' => trim($_POST['materiales'] ?? ''),
                    'tecnica' => trim($_POST['tecnica'] ?? ''),
                    'region_origen' => trim($_POST['region_origen'] ?? ''),
                    'tiempo_elaboracion' => trim($_POST['tiempo_elaboracion'] ?? ''),
                    'edicion_limitada' => isset($_POST['edicion_limitada']) ? 1 : 0,
                    'unidades_limitadas' => !empty($_POST['unidades_limitadas']) ? intval($_POST['unidades_limitadas']) : null,
                    'requiere_certificado' => isset($_POST['requiere_certificado']) ? 1 : 0,
                    'peso' => !empty($_POST['peso']) ? floatval($_POST['peso']) : null,
                    'dimensiones' => trim($_POST['dimensiones'] ?? '')
                ];
                
                if ($this->productoModel->update($id, $data)) {
                    $_SESSION['success'] = 'Producto actualizado exitosamente';
                    $this->redirect('productos/ver/' . $id);
                } else {
                    $_SESSION['error'] = 'Error al actualizar el producto';
                }
            }
        }
        
        $categorias = $this->categoriaModel->getAllActive();
        $proveedores = $this->proveedorModel->getAllActive();
        
        $this->view('productos/editar', [
            'producto' => $producto,
            'categorias' => $categorias,
            'proveedores' => $proveedores
        ]);
    }
    
    public function eliminar($id) {
        $this->requireRole(['Administrador']);
        
        $producto = $this->productoModel->getById($id);
        
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado';
            $this->redirect('productos');
        }
        
        // Soft delete - solo desactivar
        if ($this->productoModel->update($id, ['activo' => 0])) {
            $_SESSION['success'] = 'Producto eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el producto';
        }
        
        $this->redirect('productos');
    }
    
    public function categoria($id) {
        $this->requireAuth();
        
        $categoria = $this->categoriaModel->getById($id);
        
        if (!$categoria) {
            $_SESSION['error'] = 'Categoría no encontrada';
            $this->redirect('productos');
        }
        
        $productos = $this->productoModel->getByCategoria($id);
        $categorias = $this->categoriaModel->getAllWithCount();
        
        $this->view('productos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'categoria_actual' => $categoria
        ]);
    }
}
