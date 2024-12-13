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

        session_start();
    $idJugador = $_SESSION['ID'] ?? null;

    $sql = "SELECT GRUPO AS NOMBRE, 
                   SUM(PUNTAJE) AS PUNTAJE, 
                   CASE 
                       WHEN GRUPO = (SELECT GRUPO FROM JUGADORES WHERE ID_JUGADOR = :idJugador LIMIT 1) THEN 1
                       ELSE 0
                   END AS ES_GRUPO_USUARIO
            FROM JUGADORES 
            GROUP BY GRUPO 
            ORDER BY PUNTAJE DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idJugador', $idJugador, PDO::PARAM_INT);
    $stmt->execute();

    $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($grupos);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
    }
?>
