<?php
require_once '../conexion.php';

try {
    $sql = "SELECT id, nombre, simbolo FROM monedas ORDER BY nombre ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $monedas = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($monedas);
} catch (PDOException $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => 'Error al cargar monedas: ' . $e->getMessage()]);
}
?>