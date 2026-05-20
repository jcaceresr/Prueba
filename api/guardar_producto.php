<?php
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // capturar datos
    $codigo = $_POST['codigo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $bodega_id = $_POST['bodega'] ?? '';
    $sucursal_id = $_POST['sucursal'] ?? '';
    $moneda_id = $_POST['moneda'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    
    // materiales es un array
    $materiales = $_POST['materiales'] ?? []; 

    try {
        $conexion->beginTransaction();

        // insert tabla principal
        $sqlProducto = "INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, descripcion) 
                        VALUES (:codigo, :nombre, :bodega_id, :sucursal_id, :moneda_id, :precio, :descripcion) RETURNING id";
        
        $stmt = $conexion->prepare($sqlProducto);
        $stmt->execute([
            ':codigo' => $codigo,
            ':nombre' => $nombre,
            ':bodega_id' => $bodega_id,
            ':sucursal_id' => $sucursal_id,
            ':moneda_id' => $moneda_id,
            ':precio' => $precio,
            ':descripcion' => $descripcion
        ]);

        // capturar id
        $producto_id = $stmt->fetchColumn();

        // insertar materiales en tabla intermedia
        if (!empty($materiales) && is_array($materiales)) {
            $sqlMaterial = "INSERT INTO producto_materiales (producto_id, material_id) VALUES (:producto_id, :material_id)";
            $stmtMaterial = $conexion->prepare($sqlMaterial);

            foreach ($materiales as $material_id) {
                $stmtMaterial->execute([
                    ':producto_id' => $producto_id,
                    ':material_id' => $material_id
                ]);
            }
        }

        $conexion->commit();

        // Salio bien
        header('Content-Type: application/json');
        echo json_encode(['exito' => true]);

    } catch (PDOException $e) {
        // Salio mal
        $conexion->rollBack();
        
        header('Content-Type: application/json', true, 500);
        echo json_encode(['exito' => false, 'error' => 'Error al guardar el producto: ' . $e->getMessage()]);
    }
} else {
    // Si no es POST, respondemos con un error
    header('Content-Type: application/json', true, 400);
    echo json_encode(['exito' => false, 'error' => 'Método no permitido.']);
}
?>