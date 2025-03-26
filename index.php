<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA IT</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <img src="imagenes/color.jpg" alt="Logo" class="logo">
                <h1><span>SISTEMA IT Color Digital</span></h1>
                <img src="imagenes/color.jpg" alt="Logo" class="logo">
            </div>
        </header>
        <nav>
            <ul>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Agregar Equipos</a>
                    <div class="dropdown-content">
                        <a href="Agregar_Equipos/asignacion_equipo.php">Area Asignado</a>
                        <a href="Agregar_Equipos/areas_equipos.php">Areas y Equipos</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Mantenimientos Equipos</a>
                    <div class="dropdown-content">
                    <a href="Control_de_Equipos/equipos_escritorio.php">Escritorio</a>
                    <a href="Control_de_Equipos/equipos_laptop.php">Laptops</a>
                    <a href="Control_de_Equipos/equipos_tablet.php">Tablet</a>
                    <a href="Control_de_Equipos/equipos_vinetas.php">Impresoras de viñetas</a>
                    <a href="Control_de_Equipos/equipos_impresoras.php">Impresoras</a>
                    <a href="Control_de_Equipos/equipos_fotocopiadora.php">Fotocopiadoras</a>
                    <a href="Control_de_Equipos/equipos_telefono.php">Telefonos</a>
                    <a href="Control_de_Equipos/equipos_gabinete.php">Gabinetes de Red</a>
                    <a href="Control_de_Equipos/equipos_monitor.php">Monitores</a>
                    <a href="Control_de_Equipos/equipos_mouse.php">Mouse</a>
                    <a href="Control_de_Equipos/equipos_teclado.php">Teclados</a>
                    <a href="Control_de_Equipos/equipos_nas.php">NAS</a>
                    <a href="Control_de_Equipos/equipos_ap.php">AP'S</a>
                    <a href="Control_de_Equipos/equipos_servidores.php">Servidores</a>
                    <a href="Control_de_Equipos/equipos_dvr.php">DVR</a>
                    <a href="Control_de_Equipos/equipos_nvr.php">NVR</a>
                    <a href="Control_de_Equipos/equipos_camaras.php">Camaras</a>
                    <a href="Control_de_Equipos/equipos_switch.php">Switch</a>
                    <a href="Control_de_Equipos/equipos_patchpanel.php">Patch Panel</a>
                    <a href="Control_de_Equipos/equipos_ups.php">UPS</a>
                    <a href="Control_de_Equipos/equipos_bocinas.php">Bocinas</a>
                    <a href="Control_de_Equipos/equipos_proyector.php">Proyectores</a>
                    <a href="Control_de_Equipos/equipos_microfono.php">Microfonos</a>
                    <a href="Control_de_Equipos/equipos_pantallas.php">Pantallas</a>
                    <a href="Control_de_Equipos/equipos_otro.php">Otros</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Administración</a>
                    <div class="dropdown-content">
                        <a href="administracion/descargos.php">Descargos</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Reportes</a>
                    <div class="dropdown-content">
                        <a href="Reportes/reportes.php">Reportes</a>
                        <!-- <a href="Reportes/dashboard.html">Dashboard</a> -->
                    </div>
                </li>
              <!--  <li class="dropdown"> 
                    <a href="#" class="dropbtn">About</a>
                    <div class="dropdown-content">
                        <a href="creditos.html">Sistema</a>
                    </div>
                </li>-->
            </ul>
        </nav>
    </div>

    <div class="board-container">
        <div class="list-container">
            <h2>Lista de Equipos</h2>
            <ul id="equiposList"></ul>
        </div>
        <div class="chart-container">
            <canvas id="equiposChart"></canvas>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Josue Orantes. Todos los derechos reservados.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            fetch('get_data.php')
                .then(response => response.json())
                .then(data => {
                    let labels = data.map(item => item.tipo_equipo);
                    let quantities = data.map(item => item.cantidad);

                    // Crear la lista de equipos
                    let equiposList = document.getElementById('equiposList');
                    data.forEach(item => {
                        let listItem = document.createElement('li');
                        listItem.textContent = `${item.tipo_equipo}: ${item.cantidad}`;
                        equiposList.appendChild(listItem);
                    });

                    // Crear el gráfico de pastel
                    let ctx = document.getElementById('equiposChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Cantidad de Equipos',
                                data: quantities,
                                backgroundColor: [
                                    '#007bff',
                                    '#dc3545',
                                    '#ffc107',
                                    '#28a745',
                                    '#17a2b8',
                                    '#6f42c1',
                                    '#fd7e14',
                                    '#00FFFF',
                                    '#808080',
                                    '#00FF00',
                                    '#008080'
                                ],
                                borderColor: '#fff',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed !== null) {
                                                label += context.parsed;
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>






