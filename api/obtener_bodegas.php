<?php
require_once '../conexion.php';

try {
    $sql = "SELECT id, nombre FROM bodegas ORDER BY nombre ASC";
    $stmt = $conexion->prepare($sql);
    
    $stmt->execute();
    $bodegas = $stmt->fetchAll();
    
    header('Content-Type: application/json');

    echo json_encode($bodegas);

} catch (PDOException $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => 'No se pudieron cargar las bodegas: ' . $e->getMessage()]);
}
?>