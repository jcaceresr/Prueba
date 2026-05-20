<?php
require_once '../conexion.php';

$codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';

if ($codigo !== '') {
    try {
        // se busca el codigo
        $sql = "SELECT id FROM productos WHERE codigo = :codigo LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':codigo' => $codigo]);
        
        //mayor a 0, hay codigo registrado    
        $existe = $stmt->rowCount() > 0;
        
        header('Content-Type: application/json');
        echo json_encode(['existe' => $existe]);
        
    } catch (PDOException $e) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['error' => 'Error en la base de datos.']);
    }
} else {
    header('Content-Type: application/json', true, 400);
    echo json_encode(['error' => 'Código no proporcionado.']);
}
?>