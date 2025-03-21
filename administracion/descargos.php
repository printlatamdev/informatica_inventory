<?php
// Conexión a la base de datos
$cons_usuario = "root";
$cons_contra = "";
$cons_base_datos = "asignacion_equipos";
$cons_equipo = "localhost";

$obj_conexion = mysqli_connect($cons_equipo, $cons_usuario, $cons_contra, $cons_base_datos);

if (!$obj_conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Función para obtener los descargos por mes
function obtenerDescargosPorMes($obj_conexion, $offset, $limit) {
    $query = "SELECT *, MONTH(fecha_descargo) as mes, YEAR(fecha_descargo) as anio 
              FROM descargos 
              ORDER BY anio DESC, mes DESC 
              LIMIT $offset, $limit";
    $resultado = $obj_conexion->query($query);
    
    $descargos_por_mes = [];
    while ($row = $resultado->fetch_assoc()) {
        $mes_anio = $row['mes'] . '-' . $row['anio'];
        if (!isset($descargos_por_mes[$mes_anio])) {
            $descargos_por_mes[$mes_anio] = [];
        }
        $descargos_por_mes[$mes_anio][] = $row;
    }
    return $descargos_por_mes;
}

// Obtener el número total de descargos
$queryTotal = "SELECT COUNT(*) as total FROM descargos";
$resultadoTotal = $obj_conexion->query($queryTotal);
$totalDescargos = $resultadoTotal->fetch_assoc()['total'];

$limit = 20; // Número de filas por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
$offset = ($page - 1) * $limit; // Calcular el desplazamiento
$totalPages = ceil($totalDescargos / $limit);

$descargos_por_mes = obtenerDescargosPorMes($obj_conexion, $offset, $limit);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Descargos</title>
    <link rel="stylesheet" href="descargos.css">
</head>
<body>
    <div class="container">
        <center><h1>Lista de Descargos - Color Digital</h1></center>
        <?php foreach ($descargos_por_mes as $mes_anio => $descargos): ?>
            <?php
            $fecha = DateTime::createFromFormat('m-Y', $mes_anio);
            $mes = $fecha->format('F');
            $anio = $fecha->format('Y');
            ?>
            <h4><?php echo "$mes $anio"; ?></h4>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Equipo</th>
                    <th>Nombre de Host</th>
                    <th>Número de Serie</th>
                    <th>Número de Inventario</th>
                    <th>Encargado</th>
                    <th>Área Asignada</th>
                    <th>Dirección IP</th>
                    <th>Motivo</th>
                    <th>Fecha de Descargo</th>
                </tr>
                <?php foreach ($descargos as $descargo): ?>
                    <tr>
                        <td><?php echo $descargo['id']; ?></td>
                        <td><?php echo $descargo['tipo_equipo']; ?></td>
                        <td><?php echo $descargo['nombre_host']; ?></td>
                        <td><?php echo $descargo['num_serie']; ?></td>
                        <td><?php echo $descargo['num_inventario']; ?></td>
                        <td><?php echo $descargo['encargado']; ?></td>
                        <td><?php echo $descargo['area_asignada']; ?></td>
                        <td><?php echo $descargo['ip']; ?></td>
                        <td><?php echo $descargo['motivo']; ?></td>
                        <td><?php echo $descargo['fecha_descargo']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endforeach; ?>
        <br>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="pagination-button">Anterior</a>
            <?php endif; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="pagination-button">Siguiente</a>
            <?php endif; ?>
        </div>
        <br>
        <div class="button-container">
            <a href="http://localhost/HBARTOLO/#" class="button back-button">Volver</a>
        </div>
    </div>
</body>
</html>

