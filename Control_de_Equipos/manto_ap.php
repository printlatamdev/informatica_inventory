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

// Obtener ID del equipo desde la URL
$equipo_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($equipo_id > 0) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['bitacora'])) {
            $bitacora = $_POST['bitacora'];
            $update_query = "UPDATE equipo SET bitacora = ?, ultima_modificacion = NOW() WHERE id = ?";
            $stmt = $obj_conexion->prepare($update_query);
            $stmt->bind_param('si', $bitacora, $equipo_id);
            if ($stmt->execute()) {
                echo "<p>Bitácora actualizada correctamente.</p>";

                // Insertar en reportes_mantenimiento
                $select_query = "SELECT * FROM equipo WHERE id = ?";
                $stmt = $obj_conexion->prepare($select_query);
                $stmt->bind_param('i', $equipo_id);
                $stmt->execute();
                $resultado = $stmt->get_result();
                $equipo = $resultado->fetch_assoc();

                $insert_query = "INSERT INTO reportes_mantenimiento (tipo_equipo, nombre_host, num_serie, num_inventario, encargado, area_asignada, ip, bitacora, ultima_modificacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $obj_conexion->prepare($insert_query);
                $stmt->bind_param(
                    'ssssssss',
                    $equipo['tipo_equipo'], $equipo['nombre_host'], $equipo['num_serie'], $equipo['num_inventario'],
                    $equipo['encargado'], $equipo['area_asignada'], $equipo['ip'], $bitacora
                );

                if ($stmt->execute()) {
                    echo "<p>Reporte de mantenimiento guardado correctamente.</p>";
                } else {
                    echo "<p>Error al guardar el reporte de mantenimiento.</p>";
                }
            } else {
                echo "<p>Error al actualizar la bitácora.</p>";
            }
        }

        if (isset($_POST['descargo'])) {
            $motivo = $_POST['motivo'];
            $select_query = "SELECT * FROM equipo WHERE id = ?";
            $stmt = $obj_conexion->prepare($select_query);
            $stmt->bind_param('i', $equipo_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $equipo = $resultado->fetch_assoc();

            // Insertar en la tabla descargos
            $insert_query = "INSERT INTO descargos (id, tipo_equipo, nombre_host, num_serie, num_inventario, encargado, area_asignada, ip, motivo, fecha_descargo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $obj_conexion->prepare($insert_query);
            $stmt->bind_param(
                'issssssss',
                $equipo['id'], $equipo['tipo_equipo'], $equipo['nombre_host'], $equipo['num_serie'], $equipo['num_inventario'],
                $equipo['encargado'], $equipo['area_asignada'], $equipo['ip'], $motivo
            );

            if ($stmt->execute()) {
                // Eliminar de la tabla equipo
                $delete_query = "DELETE FROM equipo WHERE id = ?";
                $stmt = $obj_conexion->prepare($delete_query);
                $stmt->bind_param('i', $equipo_id);

                if ($stmt->execute()) {
                    echo "<p>Equipo descargado correctamente.</p>";
                    header("Location: http://localhost/HBARTOLO/Control_de_Equipos/equipos_ap.php");
                    exit;
                } else {
                    echo "<p>Error al eliminar el equipo de la base de datos.</p>";
                }
            } else {
                echo "<p>Error al guardar el descargo.</p>";
            }
        }
    }

    $consulta = "SELECT * FROM equipo WHERE id = $equipo_id";
    $resultado = $obj_conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        $equipo = $resultado->fetch_assoc();
    } else {
        echo "<p>Equipo no encontrado.</p>";
        exit;
    }
} else {
    echo "<p>ID de equipo inválido.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Mantenimiento - Equipo <?php echo $equipo['id']; ?></title>
    <link rel="stylesheet" href="bitacora.css">
    <style>
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .button {
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .save-button {
            background-color: #28a745;
        }
        .save-button:hover {
            background-color: #218838;
        }
        .descargo-button {
            background-color: #dc3545;
        }
        .descargo-button:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        function confirmarDescargo() {
            const motivo = document.getElementById('motivo').value;
            if (motivo.trim() === "") {
                alert("El motivo de descargo es obligatorio.");
                return;
            }
            if (confirm("¿Está seguro de hacer este descargo?")) {
                document.getElementById('descargoForm').submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h3>Detalles de Mantenimiento del Equipo <?php echo $equipo['id']; ?></h3>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $equipo['id']; ?></td>
            </tr>
            <tr>
                <th>Tipo de Equipo</th>
                <td><?php echo $equipo['tipo_equipo']; ?></td>
            </tr>
            <tr>
                <th>Nombre de Host</th>
                <td><?php echo $equipo['nombre_host']; ?></td>
            </tr>
            <tr>
                <th>Número de Serie</th>
                <td><?php echo $equipo['num_serie']; ?></td>
            </tr>
            <tr>
                <th>Número de Inventario</th>
                <td><?php echo $equipo['num_inventario']; ?></td>
            </tr>
            <tr>
                <th>Encargado</th>
                <td><?php echo $equipo['encargado']; ?></td>
            </tr>
            <tr>
                <th>Área Asignada</th>
                <td><?php echo $equipo['area_asignada']; ?></td>
            </tr>
            <tr>
                <th>Dirección IP</th>
                <td><?php echo $equipo['ip']; ?></td>
            </tr>
            <tr>
                <th>Bitácora</th>
                <td>
                    <form method="POST">
                        <textarea id="bitacora" name="bitacora" rows="4" cols="50"></textarea>
                        <br>
                        <input type="submit" value="Guardar" class="button save-button">
                    </form>
                </td>
            </tr>
            <tr>
                <th>Motivo de Descargo</th>
                <td>
                    <form id="descargoForm" method="POST">
                        <textarea id="motivo" name="motivo" rows="4" cols="50" required></textarea>
                        <br>
                        <input type="hidden" name="descargo" value="1">
                        <button type="button" onclick="confirmarDescargo()" class="button descargo-button">Descargar</button>
                    </form>
                </td>
            </tr>
        </table>
        <div class="button-container">
            <a href="http://localhost/HBARTOLO/Control_de_Equipos/equipos_ap.php" class="button back-button">Volver</a>
        </div>
    </div>
</body>
</html>