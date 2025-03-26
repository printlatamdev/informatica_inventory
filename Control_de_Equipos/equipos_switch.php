<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos Switch - COLOR DIGITAL</title>
    <link rel="stylesheet" href="styles_equipos.css">
</head>
<body>
    <div class="container">
        <h1>EQUIPOS SWITCH DEL COLOR DIGITAL</h1>
        
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Buscar...">
            <button type="submit">Buscar</button>
        </form>

        <?php
            $cons_usuario = "admin";
            $cons_contra = "AG784512";
            $cons_base_datos = "asignacion_equipos";
            $cons_equipo = "localhost";
            
            $obj_conexion = mysqli_connect($cons_equipo, $cons_usuario, $cons_contra, $cons_base_datos);
            if (!$obj_conexion) {
                echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
            } else {
                $search = isset($_GET['search']) ? mysqli_real_escape_string($obj_conexion, $_GET['search']) : '';

               // Paginación
               $limit = 20; // Número de filas por página
               $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
               $offset = ($page - 1) * $limit;

               $total_query = "SELECT COUNT(*) as total FROM equipo WHERE tipo_equipo='Switch' 
                               AND (tipo_equipo LIKE '%$search%' OR 
                                    nombre_host LIKE '%$search%' OR 
                                    num_serie LIKE '%$search%' OR 
                                    num_inventario LIKE '%$search%' OR 
                                    encargado LIKE '%$search%' OR 
                                    area_asignada LIKE '%$search%' OR 
                                    ip LIKE '%$search%')";
               $total_result = $obj_conexion->query($total_query);
               $total_rows = $total_result->fetch_assoc()['total'];
               $total_pages = ceil($total_rows / $limit);

               $var_consulta = "SELECT * FROM equipo WHERE tipo_equipo='Switch' 
                                AND (tipo_equipo LIKE '%$search%' OR 
                                     nombre_host LIKE '%$search%' OR 
                                     num_serie LIKE '%$search%' OR 
                                     num_inventario LIKE '%$search%' OR 
                                     encargado LIKE '%$search%' OR 
                                     area_asignada LIKE '%$search%' OR 
                                     ip LIKE '%$search%')
                                LIMIT $limit OFFSET $offset";

               $var_resultado = $obj_conexion->query($var_consulta);

               if ($var_resultado->num_rows > 0) {
                   echo "<div class='table-container'>
                         <table>
                             <tr>
                                 <th>ID</th>
                                 <th>TIPO DE EQUIPO</th>
                                 <th>NOMBRE DE HOST</th>
                                 <th>NÚMERO DE SERIE</th>
                                 <th>NÚMERO DE INVENTARIO</th>
                                 <th>ENCARGADO</th>
                                 <th>ÁREA ASIGNADA</th>
                                 <th>DIRECCIÓN IP</th>
                                 <th>MANTENIMIENTO</th>
                             </tr>";
                   while ($var_fila = $var_resultado->fetch_array()) {
                       echo "<tr>
                             <td>{$var_fila['id']}</td>
                             <td>{$var_fila['tipo_equipo']}</td>
                             <td>{$var_fila['nombre_host']}</td>
                             <td>{$var_fila['num_serie']}</td>
                             <td>{$var_fila['num_inventario']}</td>
                             <td>{$var_fila['encargado']}</td>
                             <td>{$var_fila['area_asignada']}</td>
                             <td>{$var_fila['ip']}</td>
                             <td><a href='manto_switch.php?id={$var_fila['id']}' class='button maintenance-button'>Mantenimiento</a></td>
                             </tr>";
                   }
                   echo "</table></div>";

                   // Paginación - Mostrar botones de anterior y siguiente
                   echo "<div class='pagination'>";
                   if ($page > 1) {
                       echo "<a href='?page=" . ($page - 1) . "&search=$search' class='pagination-button'>Anterior</a>";
                   }
                   if ($page < $total_pages) {
                       echo "<a href='?page=" . ($page + 1) . "&search=$search' class='pagination-button'>Siguiente</a>";
                   }
                   echo "</div>";
               } else {
                   echo "<p>No hay registros.</p>";
               }
           }
       ?>
       <div class="button-container">
                       <a onclick="history.back()" class="button back-button">Volver</a>
       </div>
   </div>
</body>
</html>