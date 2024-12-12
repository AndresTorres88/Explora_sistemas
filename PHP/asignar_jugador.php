<?php
session_start();
// Configuración de la base de datos
$servername = "localhost:3306";
$username = "root";
$password = "Pecesito_2020.";
$dbname = "explora";

if (isset($_POST['NOMBRE'])) {
    $nombre = $_POST['NOMBRE'];

    try {
        // Conectar a la base de datos
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener el número total de jugadores actuales
        $sqlCount = "SELECT COUNT(*) FROM JUGADORES";
        $stmtCount = $pdo->query($sqlCount);
        $totalJugadores = $stmtCount->fetchColumn();

        $puntaje = 0;
        // Determinar el grupo asignado (cíclico entre 1 a 5)
        $grupo = ($totalJugadores % 5) + 1; // El grupo será 1, 2, 3, 4, 5 cíclicamente

        // Insertar el jugador en la base de datos con su grupo asignado
        $sql = "INSERT INTO JUGADORES (NOMBRE, GRUPO, PUNTAJE) VALUES (:nombre, :grupo, :puntaje)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':grupo', $grupo, PDO::PARAM_INT);
        $stmt->bindParam(':puntaje', $puntaje, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el ID del jugador recién insertado
        $ID_JUGADOR = $pdo->lastInsertId();

        // Guardar el ID en la sesión
        $_SESSION['ID'] = $ID_JUGADOR;

        // Redirigir a la página de jugadores para ver la actualización
        header("Location: ../HTML/jugadores.html");
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
