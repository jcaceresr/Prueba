<?php
require_once '../conexion.php';

$bodega_id = isset($_GET['bodega_id']) ? intval($_GET['bodega_id']) : 0;

if ($bodega_id > 0) {
    try {
        // solo las sucursales de la bodega seleccionada
        $sql = "SELECT id, nombre FROM sucursales WHERE bodega_id = :bodega_id ORDER BY nombre ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':bodega_id' => $bodega_id]);
        $sucursales = $stmt->fetchAll();

        header('Content-Type: application/json');
        echo json_encode($sucursales);
    } catch (PDOException $e) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['error' => 'Error al cargar sucursales: ' . $e->getMessage()]);
    }
} else {
    header('Content-Type: application/json', true, 400);
    echo json_encode(['error' => 'ID de bodega no válido']);
}
?>