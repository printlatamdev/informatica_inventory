<?php
// Conexión a la base de datos
$cons_usuario = "admin";
$cons_contra = "AG784512";
$cons_base_datos = "asignacion_equipos";
$cons_equipo = "localhost";

$obj_conexion = mysqli_connect($cons_equipo, $cons_usuario, $cons_contra, $cons_base_datos);

if (!$obj_conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Manejar la búsqueda
$search_query = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['search_term'])) {
        $search_term = $_POST['search_term'];
        $search_query = "WHERE num_inventario LIKE '%$search_term%' OR ultima_modificacion LIKE '%$search_term%'";
    }
}

// Obtener el número total de reportes
$queryTotal = "SELECT COUNT(*) as total FROM reportes_mantenimiento $search_query";
$resultadoTotal = $obj_conexion->query($queryTotal);
$totalReportes = $resultadoTotal->fetch_assoc()['total'];

$limit = 20; // Número de filas por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
$offset = ($page - 1) * $limit; // Calcular el desplazamiento
$totalPages = ceil($totalReportes / $limit);

// Obtener reportes de mantenimiento
$query = "SELECT * FROM reportes_mantenimiento $search_query ORDER BY ultima_modificacion DESC LIMIT $offset, $limit";
$resultado = $obj_conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Mantenimiento</title>
    <link rel="stylesheet" href="reportes.css">
</head>
<body>
    <div class="container">
        <h3>Reportes de Mantenimiento</h3>
        <form method="POST" action="">
            <input type="text" name="search_term" placeholder="Buscar por fecha o número de inventario">
            <input type="submit" value="Buscar">
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Equipo</th>
                    <th>Número de Inventario</th>
                    <th>Área Asignada</th>
                    <th>Último Mantenimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while($reporte = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $reporte['id']; ?></td>
                            <td><?php echo $reporte['tipo_equipo']; ?></td>
                            <td><?php echo $reporte['num_inventario']; ?></td>
                            <td><?php echo $reporte['area_asignada']; ?></td>
                            <td><?php echo $reporte['ultima_modificacion']; ?></td>
                            <td>
                                <a href="descargar_pdf.php?id=<?php echo $reporte['id']; ?>" target="_blank">Descargar Informe</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No se encontraron reportes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="pagination-button">Anterior</a>
            <?php endif; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="pagination-button">Siguiente</a>
            <?php endif; ?>
        </div>
        <div class="button-container">
                    <a onclick="history.back()" class="button back-button">Volver</a>
    </div>
    </div>
</body>
</html>


                    