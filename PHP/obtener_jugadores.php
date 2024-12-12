<?php
    // Configuración de la base de datos
    $servername = "localhost:3306";
    $username = "root";
    $password = "Pecesito_2020.";
    $dbname = "explora";

    try {
        // Conectar a la base de datos
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener los jugadores y agruparlos por grupo
        $sql = "SELECT NOMBRE, GRUPO FROM JUGADORES ORDER BY GRUPO, NOMBRE";
        $stmt = $pdo->query($sql);
        $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organizar los jugadores en grupos
        $grupos = [];
        foreach ($jugadores as $jugador) {
            $grupos[$jugador['GRUPO']][] = $jugador['NOMBRE'];
        }

        // Crear una tabla para cada grupo
        for ($grupoId = 1; $grupoId <= 5; $grupoId++) {
            if (isset($grupos[$grupoId])) {
                echo "<table class='tabla'>";
                echo "<tr><th colspan='3'>Grupo $grupoId</th></tr>";

                // Dividir los nombres en filas de 3
                $filas = array_chunk($grupos[$grupoId], 3);
                foreach ($filas as $fila) {
                    echo "<tr>";
                    foreach ($fila as $nombre) {
                        echo "<td><span class='text'>$nombre</span></td>";
                    }

                    // Completar las celdas vacías si la fila tiene menos de 3 nombres
                    for ($i = count($fila); $i < 3; $i++) {
                        echo "<td></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // Si no hay jugadores en un grupo, lo dejamos vacío
                echo "<table class='tabla'>";
                echo "<tr><th colspan='3'>Grupo $grupoId</th></tr>";
                echo "<tr><td colspan='3'>Sin jugadores</td></tr>";
                echo "</table>";
            }
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>

