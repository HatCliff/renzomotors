<?php
    require_once(__DIR__ . "/../config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>RenzoMotors</title>
</head>
<body class="pt-5 mt-3">
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
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Ventas Mensuales (TOTAL)</span></div>
                                <div class="text-dark fw-bold h5 mb-0"><span>$40,000</span></div>
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
                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Ventas Annuales (TOTAL)</span></div>
                                <div class="text-dark fw-bold h5 mb-0"><span>$215,000</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-info py-2">
                    <div class="card-body">
                        <div class="row g-0 align-items-center">
                            <div class="col me-2">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Reservas concretadas</span></div>
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark fw-bold h5 mb-0 me-3"><span>50%</span></div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"><span class="visually-hidden">50%</span></div>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="text-dark fw-bold h5 mb-0"><span>18</span></div>
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
                                            echo "<a class='dropdown-item' href='#'>$row[nombre_sucursal]</a>";
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
    <div id="lineChart" style="width: 100%; height: 400px;"></div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawLineChart);

        function drawLineChart() {
            var data = google.visualization.arrayToDataTable([
                ['Mes', 'Ventas'],
                ['Enero', 1000],
                ['Febrero', 1170],
                ['Marzo', 660],
                ['Abril', 1030],
                ['Mayo', 800],
                ['Junio', 920]
            ]);

            var options = {
                title: 'Ventas Mensuales',
                curveType: 'function', // Para suavizar las líneas
                legend: { position: 'bottom' },
                height: 400,
                hAxis: {
                    title: 'Mes',
                    titleTextStyle: { bold: true }
                },
                vAxis: {
                    title: 'Ventas',
                    titleTextStyle: { bold: true }
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('lineChart'));
            chart.draw(data, options);
        }
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
