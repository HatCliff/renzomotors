<?php
   // require_once("./../config/conexion.php");
    require('./dashboard/queries.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <title>RenzoMotors</title>

</head>
<body class="pt-5 mt-3">
<style>
        .progress-container {
            position: relative;
            width: 100%;
        }
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
        }
    </style>
<?php include __DIR__ . "/../admin/navbaradmin.php"; ?>
    <div class="container-fluid p-5">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Dashboard</h3><a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-primary py-2">
                    <div class="card-body">
                        <div class="row g-0 align-items-center">
                            <div class="col me-2">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Contador de Ventas</span></div>
                                <div class="text-dark fw-bold h5 mb-0"><span><?php echo ContadorVentaAccesorios(); ?></span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-success py-2">
                    <div class="card-body">
                        <div class="row g-0 align-items-center">
                            <div class="col me-2">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Ventas Anuales (TOTAL)</span></div>
                                <div class="text-dark fw-bold h5 mb-0"><span>$<?php echo ContadorVentaTotalAccesorios();?> </span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-info ">
                    <div class="card-body">
                        <div class="row g-0 align-items-center">
                            <div class="col me-2">
                            <?php
                                            $reservas = ContadorReservasConcretadas();
                                            $total_res = $reservas['reservas_concretadas'] + $reservas['reservas_no_concretadas'];
                                            $porcentaje_reservas_concretadas = round(($reservas['reservas_concretadas']/$total_res)*100);
                                            $porcentaje_reservas_no_concretadas = round(($reservas['reservas_no_concretadas']/$total_res)*100);
                                            $reservas_concretadas = $reservas['reservas_concretadas'];
                                            $reservas_no_concretadas = $reservas['reservas_no_concretadas'];
                                        ?>
                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Reservas concretadas: <?php 
                                        echo $reservas_concretadas;
                                ?></span></div>
                                
                                <div class="progress-container mb-4">
                                    
                                    <div class="progress">

                                        <div class="progress-bar bg-primary" role="progressbar" style="width:<?php
                                                                                                                echo $porcentaje_reservas_concretadas;                                      
                                                                                                                ?>%;" aria-valuenow="
                                                                                                                <?php
                                                                                                                echo $porcentaje_reservas_concretadas;
                                                                                                                ?>" aria-valuemin="0" aria-valuemax="100"><?php
                                                                                                                echo $porcentaje_reservas_concretadas;
                                                                                                                ?>%</div>
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php 
                                                                                                    echo $porcentaje_reservas_no_concretadas;
                                                                                                    ?>%;" aria-valuenow="<?php
                                                                                                    echo $porcentaje_reservas_no_concretadas;
                                                                                                    ?>" aria-valuemin="0" aria-valuemax="100"><?php
                                                                                                    echo $porcentaje_reservas_no_concretadas;
                                                                                                    ?>%</div>
                                    </div>
                                </div>
                                
                                                            
                                <!---
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark fw-bold h5 mb-0 me-3"><span><?php echo ContadorReservasConcretadas(); ?></span></div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"><span class="visually-hidden">50%</span></div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                            <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-warning py-2">
                    <div class="card-body">
                        <div class="row g-0 align-items-center">
                            <div class="col me-2">
                                <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Seguros contratados</span></div>
                                <div class="text-dark fw-bold h5 mb-0"><span><?php echo ContadorSegurosContratados(); ?></span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Historico ventas por local</h6>
                        <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">Local:</p>
                                    <?php
                                        $query = "SELECT * FROM sucursal";
                                        $resultado = mysqli_query($conexion, $query);
                                        while ($row = mysqli_fetch_array($resultado)) {
                                            echo "<button class='dropdown-item' onClick='cargarGrafico(`$row[nombre_sucursal]`)'>$row[nombre_sucursal]</button>";
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
    <div id="lineChart" style="width: 100%; height: 400px;"></div>
    <script>
        function cargarGrafico(argument){
            console.log("Cargando gráfico...");
        // Dimensiones del gráfico

        const width = 600;
        const height = 400;
        const margin = { top: 50, right: 50, bottom: 50, left: 50 };

        // Selección del contenedor y eliminar sus hijos para luego hacerle append
        d3.select("#lineChart").selectAll("*").remove();
        var svg = d3.select("#lineChart")
            .append("svg")
            .attr("width", width)
            .attr("height", height);

            console.error("Valor por defecto:", argument);
            d3.json(`./dashboard/chartAjax.php?local=${argument}`).then(data => {
    console.log("Datos recibidos:", data); // Asegúrate de ver los datos en la consola

    if (!data || data.length === 0) {
        console.log("No hay datos disponibles");
        return;
    }

    // Convertir ventas a números
    data.forEach(d => d.ventas = +d.ventas);

    // Escalas
    const xScale = d3.scaleBand()
        .domain(data.map(d => d.mes))
        .range([margin.left, width - margin.right])
        .padding(0.1);

    const yScale = d3.scaleLinear()
        .domain([0, d3.max(data, d => d.ventas)])
        .nice()
        .range([height - margin.bottom, margin.top]);

    // Ejes
    const xAxis = d3.axisBottom(xScale);
    const yAxis = d3.axisLeft(yScale);

    svg.append("g")
        .attr("transform", `translate(0, ${height - margin.bottom})`)
        .call(xAxis)
        .attr("font-size", "12px");

    svg.append("g")
        .attr("transform", `translate(${margin.left}, 0)`)
        .call(yAxis)
        .attr("font-size", "12px");

    // Línea
    const line = d3.line()
        .x(d => xScale(d.mes) + xScale.bandwidth() / 2)
        .y(d => yScale(d.ventas));

    svg.append("path")
        .datum(data)
        .attr("fill", "none")
        .attr("stroke", "steelblue")
        .attr("stroke-width", 2)
        .attr("d", line);

    // Puntos
    svg.selectAll(".circle")
        .data(data)
        .enter()
        .append("circle")
        .attr("cx", d => xScale(d.mes) + xScale.bandwidth() / 2)
        .attr("cy", d => yScale(d.ventas))
        .attr("r", 4)
        .attr("fill", "steelblue");

}).catch(error => {
    console.error("Error al cargar los datos:", error);
});

        }
        cargarGrafico('null');
    </script>
</div>

                </div>
            </div>
            <div class="col-lg-5 col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Reservas concretadas por local</h6>
                        <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">Local:</p> 
                                    <?php
                                        $query = "SELECT * FROM sucursal";
                                        $resultado = mysqli_query($conexion, $query);
                                        while ($row = mysqli_fetch_array($resultado)) {
                                            echo "<a class='dropdown-item' href='#'>$row[nombre_sucursal]</a>";
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
    <div id="doughnutChart" style="width: 100%; height: 400px;"></div>
    <script>
        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Sucursal', 'Reservas'],
                ['Sucursal 1', 10],
                ['Sucursal 2', 20],
                ['Sucursal 3', 30]
            ]);

            var options = {
                title: 'Reservas concretadas por local',
                pieHole: 0.4,
                legend: { position: 'top' },
                height: 400
            };

            var chart = new google.visualization.PieChart(document.getElementById('doughnutChart'));
            chart.draw(data, options);
        }
    </script>
</div>


                </div>
            </div>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
