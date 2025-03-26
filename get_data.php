<?php
$servername = "localhost";
$dbname = "asignacion_equipos";
$username = "admin";
$password = "AG784512";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener la cantidad de equipos por tipo
$sql = "SELECT tipo_equipo, COUNT(*) as cantidad FROM equipo GROUP BY tipo_equipo";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 resultados";
}
$conn->close();

echo json_encode($data);
?>
