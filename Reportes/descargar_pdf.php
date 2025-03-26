<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Conexión a la base de datos
$cons_usuario = "admin";
$cons_contra = "AG784512";
$cons_base_datos = "asignacion_equipos";
$cons_equipo = "localhost";

$obj_conexion = mysqli_connect($cons_equipo, $cons_usuario, $cons_contra, $cons_base_datos);

if (!$obj_conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$reporte_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($reporte_id > 0) {
    $consulta = "SELECT * FROM reportes_mantenimiento WHERE id = $reporte_id";
    $resultado = $obj_conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        $reporte = $resultado->fetch_assoc();

        // Leer el contenido del archivo CSS
        $css = file_get_contents('style.css');

        $html = "
            <html>
            <head>
                <style>$css</style>
            </head>
            <body>
                <div class='report-container'>
                    <header>
                        <div class='header-images'>
                        </div>
                        <h1>HOJA DE TRABAJO - UNIDAD IT</h1>
                        <h2>COLOR DIGITAL</h2>
                        <h3>Reporte de Mantenimiento</h3>
                    </header>
                    <table>
                        <tr>
                            <th>ID</th>
                            <td>{$reporte['id']}</td>
                        </tr>
                        <tr>
                            <th>Tipo de Equipo</th>
                            <td>{$reporte['tipo_equipo']}</td>
                        </tr>
                        <tr>
                            <th>Número de Inventario</th>
                            <td>{$reporte['num_inventario']}</td>
                        </tr>
                        <tr>
                            <th>Área Asignada</th>
                            <td>{$reporte['area_asignada']}</td>
                        </tr>
                        <tr>
                            <th>Fecha Mantenimiento</th>
                            <td>{$reporte['ultima_modificacion']}</td>
                        </tr>
                        <tr>
                            <th>Detalles de Mantenimiento</th>
                            <td>{$reporte['bitacora']}</td>
                        </tr>
                    </table>
                    <div class='signatures'>
                        <div class='signature'>
                            <p>Encargado de Mantenimiento</p>
                            <p>Josue Orantes</p>
                            <p>Firma Asignado: ___________________________</p>
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class='signature'>
                            <p>Recibe</p>
                            <p>Nombre: ___________________________</p>
                            <p>Firma: ___________________________</p>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </body>
            </html>
        ";

        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Enviar el PDF al navegador
        $dompdf->stream('reporte_mantenimiento.pdf', array('Attachment' => 0));
    } else {
        echo "Reporte no encontrado.";
    }
} else {
    echo "ID de reporte inválido.";
}
?>



