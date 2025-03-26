<?php
$servername = "localhost";
$dbname = "asignacion_equipos";
$username = "admin";
$password = "AG784512";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicializar variables para errores
$errores = array();

// Función para actualizar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        // Validar los datos antes de actualizar
        $id = $_POST['id'];
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

        // Ejemplo de validación básica
        if (empty($tipo_equipo)) {
            $errores[] = "El campo Tipo de Equipo es obligatorio";
        }

        if (empty($nombre_host)) {
            $errores[] = "El campo Nombre de Host es obligatorio";
        }

        // Si no hay errores, proceder con la actualización
        if (empty($errores)) {
            $sql = "UPDATE equipo SET tipo_equipo='$tipo_equipo', nombre_host='$nombre_host', num_serie='$num_serie', num_inventario='$num_inventario', encargado='$encargado', area_asignada='$area_asignada', ip='$ip', licencia_windows='$licencia_windows', licencia_office='$licencia_office', antivirus='$antivirus', comentario='$comentario' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo "Registro actualizado correctamente";
            } else {
                echo "Error al actualizar el registro: " . $conn->error;
            }
        }
    }
}

$searchTerm = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];
}

// Configuración de la paginación
$limit = 20; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual
$offset = ($page - 1) * $limit; // Calcular el desplazamiento

$sqlCount = "SELECT COUNT(*) as total FROM equipo";
if (!empty($searchTerm)) {
    $sqlCount .= " WHERE area_asignada LIKE '%$searchTerm%' OR tipo_equipo LIKE '%$searchTerm%'";
}
$resultCount = $conn->query($sqlCount);
$totalRows = $resultCount->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

$sql = "SELECT id, tipo_equipo, nombre_host, num_serie, num_inventario, encargado, area_asignada, ip, licencia_windows, licencia_office, antivirus, comentario FROM equipo";
if (!empty($searchTerm)) {
    $sql .= " WHERE area_asignada LIKE '%$searchTerm%' OR id LIKE '%$searchTerm%' OR num_serie LIKE '%$searchTerm%' OR tipo_equipo LIKE '%$searchTerm%' OR num_inventario LIKE '%$searchTerm%' OR ip LIKE '%$searchTerm%' OR area_asignada LIKE '%$searchTerm%'";
}
$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas de Color Digital</title>
    <link rel="stylesheet" href="areas_equipos.css">
</head>
<body>
    <div class="container">
        <h1>Áreas de Color Digital</h1>
        <form class="search-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="searchTerm">Buscar:</label>
            <input type="text" id="searchTerm" name="searchTerm" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <input type="submit" value="Buscar">
        </form>
        <div class="new-button-container">
            <a href="http://localhost/HBARTOLO/#" class="btn1">Regresar</a>
        </div>
    </div>
    <br><br>

    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Tipo de Equipo</th>
                <th>Nombre de Host</th>
                <th>Número de Serie</th>
                <th>Número de Inventario</th>
                <th>Encargado</th>
                <th>Área Asignada</th>
                <th>IP</th>
                <th>Licencia de Windows</th>
                <th>Licencia de Office</th>
                <th>Antivirus</th>
                <th>Comentario</th>
                <th>Acción</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Mostrar cada fila de datos con un formulario para editar
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <form method='post' action='{$_SERVER['PHP_SELF']}'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <td>{$row['id']}</td>
                                <td><input type='text' name='tipo_equipo' value='{$row['tipo_equipo']}' disabled></td>
                                <td><input type='text' name='nombre_host' value='{$row['nombre_host']}' disabled></td>
                                <td><input type='text' name='num_serie' value='{$row['num_serie']}' disabled></td>
                                <td><input type='text' name='num_inventario' value='{$row['num_inventario']}' disabled></td>
                                <td><input type='text' name='encargado' value='{$row['encargado']}' disabled></td>
                                <td><input type='text' name='area_asignada' value='{$row['area_asignada']}' disabled></td>
                                <td><input type='text' name='ip' value='{$row['ip']}' disabled></td>
                                <td><input type='text' name='licencia_windows' value='{$row['licencia_windows']}' disabled></td>
                                <td><input type='text' name='licencia_office' value='{$row['licencia_office']}' disabled></td>
                                <td><input type='text' name='antivirus' value='{$row['antivirus']}' disabled></td>
                                <td><input type='text' name='comentario' value='{$row['comentario']}' disabled></td>
                                <td>
                                    <button type='button' class='edit-button' onclick='enableEditing(this)'>Editar</button>
                                    <input type='submit' class='update-button' name='update' value='Actualizar'>
                                </td>
                            </form>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='14'>0 resultados</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="pagination">
        <?php if($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="pagination-button">Anterior</a>
        <?php endif; ?>
        <?php if($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="pagination-button">Siguiente</a>
        <?php endif; ?>
    </div>

    <div class="button">
        <button onclick="goBack1()">Regresar</button>
    </div>
    <script>
        function enableEditing(button) {
            // Obtener la fila en la que se encuentra el botón
            var row = button.parentNode.parentNode;

            // Habilitar todos los campos de entrada en esa fila
            var inputs = row.querySelectorAll('input[type="text"]');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].disabled = false;
            }

            // Mostrar el botón de actualizar y ocultar el botón de editar
            var updateButton = row.querySelector('input[type="submit"]');
            updateButton.style.display = 'inline';

            button.style.display = 'none';
        }

        function goBack1() {
           // window.history.back();
            window.location.href = "http://localhost/HBARTOLO/#";
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
