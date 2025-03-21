<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Equipo Agregado</title>
    <link rel="stylesheet" href="agregar_equipo.css">
</head>
<body>

    <div class="container">
        <h1>EQUIPO ASIGNADO CORRECTAMENTE</h1>
        <?php
        // Mostrar los datos del formulario
        echo "<p>Tipo de Equipo: " . $_POST['tipo_equipo'] . "</p>";
        echo "<p>Nombre Host: " . $_POST['nombre_host'] . "</p>";
        echo "<p>Número de Serie: " . $_POST['num_serie'] . "</p>";
        echo "<p>Número de Inventario: " . $_POST['num_inventario'] . "</p>";
        echo "<p>Encargado en Recibir: " . $_POST['encargado'] . "</p>";
        echo "<p>Area Asignada: " . $_POST['area_asignada'] . "</p>";
        echo "<p>IP: " . $_POST['ip'] . "</p>";
        echo "<p>Licencia Windows: " . $_POST['licencia_windows'] . "</p>";
        echo "<p>Licencia Office: " . $_POST['licencia_office'] . "</p>";
        echo "<p>Antivirus: " . $_POST['antivirus'] . "</p>";
        echo "<p>Comentario: " . $_POST['comentario'] . "</p>";
 ?>
    </div>
<br><br>
<div class="button">
    <!-- Botón de retroceso -->
    <button onclick="goBack()">Regresar</button>
</div>

<script>
    // Función para retroceder a la página anterior
    function goBack() {
        window.location.href = "http://localhost/HBARTOLO/Agregar_Equipos/asignacion_equipo.php";
    }
</script>
    </div>
	<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asignacion_equipos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $tipo_equipo = $_POST['tipo_equipo'];
    $nombre_host = $_POST['nombre_host'];
    $num_serie = $_POST['num_serie'];
    $num_inventario = $_POST['num_inventario'];
    $encargado = $_POST['encargado'];
    $area_asignada = $_POST['area_asignada'];
    $ip = $_POST['ip'];
    $licencia_windows = $_POST['licencia_windows'];
    $licencia_office = $_POST['licencia_office'];
    $antivirus = $_POST['antivirus'];
    $comentario = $_POST['comentario'];

    // Verificar que todos los campos requeridos no estén vacíos
    if(empty($tipo_equipo) || empty($nombre_host) || empty($num_serie) || empty($num_inventario) || empty($encargado) || empty($area_asignada)) {
        echo "<p>Por favor, complete todos los campos requeridos.</p>";
    } else {
        // Sentencia preparada para prevenir SQL injection
        $stmt = $conn->prepare("INSERT INTO equipo (tipo_equipo, nombre_host, num_serie, num_inventario, encargado, area_asignada, ip, licencia_windows, licencia_office, antivirus, comentario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if($stmt === false) {
            die("Error en la preparación de la sentencia: " . $conn->error);
        }

        $stmt->bind_param("sssssssssss", $tipo_equipo, $nombre_host, $num_serie, $num_inventario, $encargado, $area_asignada, $ip, $licencia_windows, $licencia_office, $antivirus, $comentario);

        // Ejecutar la sentencia y verificar si fue exitosa
        if ($stmt->execute()) {
            // Redireccionar a agregar_equipo.php en caso de éxito
           // header("Location: agregar_equipo.php");
           echo "<p>SUS DATOS FUERON GUARDADOS EXITOSAMENTE...</p>";
		   exit(); // Asegurar que el script termina después de la redirección
        } else {
            echo "<p>Ocurrió un error al agregar el equipo. Por favor, inténtalo de nuevo más tarde.</p>";
            error_log("Error al insertar datos en la base de datos: " . $stmt->error);
        }

        // Cerrar la sentencia
        $stmt->close();
    }
}

// Cerrar la conexión
$conn->close();
?>
</body>
</html>
