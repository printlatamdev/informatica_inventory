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
        <h1>Orden</h1>
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
    <button class="imprimir-btn" onclick="imprimirPagina()">Imprimir</button>
<script>
function imprimirPagina() {
window.print();
}
</script>
<br><br>
        <div class="button">
        <!-- Botón de retroceso -->
        <button onclick="goBack()">Regresar</button>
        </div>
    <script>
        // Función para retroceder a la página anterior
        function goBack() {
            window.history.back();
        }
    </script>
    </div>
</body>
</html>
