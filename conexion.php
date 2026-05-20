<?php

$host     = "localhost";
$port     = "5432"; 
$dbname   = "prueba";
$user     = "postgres";
$password = "postgres";

try {

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
    $conexion = new PDO($dsn, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error crítico en la conexión a la base de datos: " . $e->getMessage());
}
?>