<!DOCTYPE html>
<html>
<head>
    <title>Asignación de Equipo</title>
    <link rel="stylesheet" type="text/css" href="asignacion_equipo.css">
</head>
<body>
    <div class="container">
        <h1>Asignación de EQUIPOS</h1>
        <form action="agregar_equipo.php" method="post">
            <label for="tipo_equipo">Tipo de Equipo:</label>
            <select id="tipo_equipo" name="tipo_equipo" required>
                <option value="___">SELECCIONE</option>
                <option value="Escritorio">PC Escritorio</option>
                <option value="Laptop">Laptop</option>
                <option value="Tablet">Tablet</option>
                <option value="Telefono">Telefonos Red</option>
                <option value="Impresora">Impresora</option>
                <option value="Fotocopiadora">Fotocopiadora</option>
                <option value="Gabinete">Gabinetes Red</option>
                <option value="Monitor">Monitor</option>
                <option value="Teclado">Teclado</option>
                <option value="Ap">AP</option>
                <option value="Switch">Switch</option>
                <option value="Patchpanel">Patch Panel</option>
                <option value="Ups">UPS</option>
                <option value="Bocina">Bocinas</option>
                <option value="Proyector">Proyectores</option>
                <option value="Microfono">Microfonos</option>
                <option value="Pantalla">Pantallas</option>
                <option value="Otro">Otros</option>

                <!-- Agrega más opciones según sea necesario -->
            </select><br><br>

            <label for="nombre_host">Nombre Host:</label>
            <input type="text" id="nombre_host" name="nombre_host" required><br><br>

            <label for="num_serie">Número de Serie:</label>
            <input type="text" id="num_serie" name="num_serie" required><br><br>

            <label for="num_inventario">Número de Inventario:</label>
            <input type="text" id="num_inventario" name="num_inventario" required><br><br>

            <label for="encargado">Encargado en Recibir:</label>
            <input type="text" id="encargado" name="encargado" required><br><br>

            <label for="area_asignada">Area Asignada:</label>
            <select id="area_asignada" name="area_asignada" required>
                <option value="__">SELECCIONE</option>
                <option value="IT">IT</option>
                <option value="ARQUITECTO">Arquitecto</option>
                <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
                <option value="COMPRAS">COMPRAS</option>
                <option value="PLANIFICACION">PLANIFICACION</option>
                <option value="CONTABILIDAD">CONTABILIDAD</option>
                <option value="EXPORTACION">EXPORTACION</option>
                <option value="RECEPCION">RECEPCION</option>
                <option value="JURIDICA">JURIDICA</option>
                <option value="SERVIDOR">SERVIDOR</option>
                <option value="FACTURACION">FACTURACION</option>
                <option value="LOGISTICA">LOGISTICA</option>
                <option value="IMPRECION">IMPRECION</option>
                <option value="CORTE">CORTE</option>
                <option value="DISENO">DISEÑO</option>
            </select><br><br>

            <label for="ip">IP:</label>
            <input type="text" id="ip" name="ip"><br><br>

            <label for="licencia_windows">Licencia Windows:</label>
            <input type="text" id="licencia_windows" name="licencia_windows"><br><br>

            <label for="licencia_office">Licencia Office:</label>
            <input type="text" id="licencia_office" name="licencia_office"><br><br>

            <label for="antivirus">Antivirus:</label>
            <input type="text" id="antivirus" name="antivirus"><br><br>

            <label for="comentario">Comentario:</label><br>
            <textarea id="comentario" name="comentario" rows="4" cols="50"></textarea><br><br>

            <input type="submit" value="Agregar Equipo">

        </form>
    </div>
    <div class="button-container">
            <a href="http://localhost/HBARTOLO/#" class="button back-button">Volver</a>
        </div>

</body>
</html>