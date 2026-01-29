<?php
    $host = "db";
    $usuario = "app";
    $contraseña = "app";
    $baseDeDatos = "energia";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$baseDeDatos;charset=utf8", $usuario, $contraseña); //Crear conexión con la bd mediante PDO
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }

    // Función para obtener precios por fecha
    function obtenerPreciosPorFecha($conexion, $fecha) {
        try {
            $sql = "SELECT hora, precio FROM precios_luz WHERE fecha = :fecha ORDER BY hora ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); //Aquí se crea el array
        } catch (PDOException $e) {
            return [];
        }
    }

?>
