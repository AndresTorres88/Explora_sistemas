<?php
    $servername = "localhost:3306";
    $username = "root";
    $password = "Pecesito_2020.";
    $dbname = "explora";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT MAX(ULTIMA_ACTUALIZACION) AS ULTIMA_ACTUALIZACION FROM JUGADORES";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode(['ULTIMA_ACTUALIZACION' => $result['ULTIMA_ACTUALIZACION']]);

    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
