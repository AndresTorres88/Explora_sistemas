<?php
    // Configuración de la base de datos
    $servername = "localhost:3306";
    $username = "root";
    $password = "Pecesito_2020.";
    $dbname = "explora";

    header('Content-Type: application/json');

    try {
        // Conectar a la base de datos
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consultar la clasificación agrupada por grupo, ordenada por puntaje acumulado de mayor a menor
        $sql = "SELECT GRUPO AS NOMBRE, SUM(PUNTAJE) AS PUNTAJE 
                FROM JUGADORES 
                GROUP BY GRUPO 
                ORDER BY PUNTAJE DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Obtener los datos y devolverlos en formato JSON
        $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($grupos);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
    }
?>
