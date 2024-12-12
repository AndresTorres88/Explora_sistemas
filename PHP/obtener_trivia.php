<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost:3306";
$username = "root";
$password = "Pecesito_2020.";
$dbname = "explora";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID de la pista desde la URL
    $id_pista = isset($_GET['ID_PISTA']) ? intval($_GET['ID_PISTA']) : 1;

    // Consultar la trivia desde la base de datos
    $sql = "SELECT * FROM TRIVIA WHERE ID_PISTA = :id_pista";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_pista', $id_pista);
    $stmt->execute();

    // Verificar si se encontró la trivia
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Aquí se asume que tienes las respuestas almacenadas en diferentes campos en la base de datos
        $respuestas = [
            [
                'texto' => $row['RESPUESTA_CORRECTA'],
                'esCorrecta' => true
            ],
            [
                'texto' => $row['RESPUESTA_INCORRECTA1'],
                'esCorrecta' => false
            ],
            [
                'texto' => $row['RESPUESTA_INCORRECTA2'],
                'esCorrecta' => false
            ],
            [
                'texto' => $row['RESPUESTA_INCORRECTA3'],
                'esCorrecta' => false
            ]
        ];

        // Mezclamos las respuestas de forma aleatoria
        shuffle($respuestas);

        // Devolver la pregunta y las respuestas en formato JSON
        echo json_encode([
            'pregunta' => $row['PREGUNTA'],
            'respuestas' => $respuestas
        ]);
    } else {
        echo json_encode([
            'pregunta' => 'No se encontró la trivia.',
            'respuestas' => []
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Error de conexión: ' . $e->getMessage()
    ]);
}
?>
