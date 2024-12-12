<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $servername = "localhost:3306";
    $username = "root";
    $password = "Pecesito_2020.";
    $dbname = "explora";


    try {
        // Establecer la conexión utilizando PDO
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Establecer el modo de error a excepción
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Obtener el ID de la pista desde la URL
        $id_pista = isset($_GET['id_pista']) ? intval($_GET['id_pista']) : 1;
        
        // Consultar la pista desde la base de datos
        $sql = "SELECT * FROM PISTAS WHERE ID_PISTA = :id_pista";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_pista', $id_pista, PDO::PARAM_INT);
        $stmt->execute();
        
        // Verificar si se encontró la pista
        if ($stmt->rowCount() > 0) {
            // Obtener los datos de la pista
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Devolver la pista en formato JSON
            echo json_encode([
                'pista' => $row['INFORMACION'], // Asegúrate de que 'INFORMACION' es el campo correcto
                'imagen' => $row['IMAGEN']
            ]);
        } else {
            echo json_encode([
                'pista' => 'No se encontró la pista.'
            ]);
        }
    
    } catch (PDOException $e) {
        // En caso de error en la conexión o consulta
        echo json_encode([
            'error' => 'Error de conexión: ' . $e->getMessage()
        ]);
    }
?>