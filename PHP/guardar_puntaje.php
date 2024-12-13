<?php
// Iniciar sesión para obtener el ID del jugador
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// Configuración de la base de datos
$servername = "localhost:3306";
$username = "root";
$password = "Pecesito_2020.";
$dbname = "explora";

// Verificar que la solicitud sea un POST y que contenga datos JSON
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"));

    // Validar si se recibieron los parámetros correctamente
    if (isset($data->puntaje) && isset($_SESSION['ID'])) {
        $idJugador = $_SESSION['ID']; // Obtener el ID del jugador desde la sesión
        $puntajeObtenido = $data->puntaje; // Puntaje obtenido en la trivia

        try {
            // Conectar a la base de datos
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Obtener el puntaje actual del jugador
            $sql = "SELECT PUNTAJE FROM JUGADORES WHERE ID_JUGADOR = :idJugador";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idJugador', $idJugador, PDO::PARAM_INT);
            $stmt->execute();
            $currentPuntaje = $stmt->fetchColumn();

            if ($currentPuntaje === false) {
                // Si no se encuentra el jugador, devolver error
                echo json_encode([
                    'success' => false,
                    'error' => 'Jugador no encontrado'
                ]);
                exit;
            }

            // Acumular el puntaje
            $nuevoPuntaje = $currentPuntaje + $puntajeObtenido;

            // Actualizar el puntaje acumulado del jugador en la base de datos
            $sqlUpdate = "UPDATE JUGADORES SET PUNTAJE = :nuevoPuntaje WHERE ID_JUGADOR = :idJugador";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':nuevoPuntaje', $nuevoPuntaje, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':idJugador', $idJugador, PDO::PARAM_INT);
            $stmtUpdate->execute();

            // Responder con éxito
            echo json_encode(['success' => true, 'nuevoPuntaje' => $nuevoPuntaje]);

        } catch (PDOException $e) {
            // Manejo de errores
            echo json_encode([
                'success' => false,
                'error' => 'Error al guardar el puntaje: ' . $e->getMessage()
            ]);
        }
    } else {
        // Si faltan parámetros
        echo json_encode([
            'success' => false,
            'error' => 'Parámetros incompletos'
        ]);
    }
} else {
    // Si la solicitud no es POST
    echo json_encode([
        'success' => false,
        'error' => 'Solicitud inválida'
    ]);
}
?>
