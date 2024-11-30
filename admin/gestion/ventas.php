<?php
// require_once("./../config/conexion.php");
require('./ventas/queries.php');
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
         /* Estilos específicos para el gráfico de dona */
  #doughnutChart {
    
    position: relative;
  }

  #doughnutChart svg {
    width: 100%;
    height: 100%;
  }

  #doughnutChart path.slice {
    stroke-width: 2px;
  }

  #doughnutChart polyline {
    opacity: .3;
    stroke: black;
    stroke-width: 2px;
    fill: none;
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
                                <div class="text-dark fw-bold h5 mb-0"><span>$<?php echo ContadorVentaTotalAccesorios(); ?> </span></div>
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
                                $porcentaje_reservas_concretadas = round(($reservas['reservas_concretadas'] / $total_res) * 100);
                                $porcentaje_reservas_no_concretadas = round(($reservas['reservas_no_concretadas'] / $total_res) * 100);
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
 function cargarGrafico(local) {
    console.log("Cargando gráfico...");

    // Crear el gradiente para el gráfico
    const createGradient = (select) => {
        const gradient = select
            .select("defs")
            .append("linearGradient")
            .attr("id", "gradient")
            .attr("x1", "0%")
            .attr("y1", "100%")
            .attr("x2", "0%")
            .attr("y2", "0%");

        gradient
            .append("stop")
            .attr("offset", "0%")
            .attr("style", "stop-color:#BBF6CA;stop-opacity:0.05");

        gradient
            .append("stop")
            .attr("offset", "100%")
            .attr("style", "stop-color:#BBF6CA;stop-opacity:.5");
    };

    // Crear el filtro de brillo para el gráfico
    const createGlowFilter = (select) => {
        const filter = select
            .select("defs")
            .append("filter")
            .attr("id", "glow");

        filter
            .append("feGaussianBlur")
            .attr("stdDeviation", "4")
            .attr("result", "coloredBlur");

        const femerge = filter.append("feMerge");
        femerge.append("feMergeNode").attr("in", "coloredBlur");
        femerge.append("feMergeNode").attr("in", "SourceGraphic");
    };

    // Dimensiones del gráfico
    const container = d3.select("#lineChart");
    const width = container.node().clientWidth;
    const height = container.node().clientHeight;
    const margin = { top: 50, right: 50, bottom: 50, left: 50 };

    // Limpiar el contenedor antes de renderizar el gráfico
    container.selectAll("*").remove();

    // Crear el SVG principal
    const svg = container
        .append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", `translate(${margin.left}, ${margin.top})`);

    // Agregar definiciones (para gradiente y brillo)
    svg.append("defs");
    svg.call(createGradient);
    svg.call(createGlowFilter);

    // Construir la URL de la API

    // Cargar datos desde la API
    d3.json(`./dashboard/chartAjax.php?local='${local}'`)
        .then((data) => {
            if (!data || data.length === 0) {
                console.log("No hay datos disponibles.");
                
                // Mostrar mensaje de "No hay datos"
                svg.append("text")
                    .attr("text-anchor", "middle")
                    .attr("x", (width - margin.left - margin.right) / 2)
                    .attr("y", (height - margin.top - margin.bottom) / 2)
                    .attr("class", "no-data-message")
                    .style("font-size", "16px")
                    .style("fill", "gray")
                    .text("No hay datos disponibles.");
                return;
            }

            // Parsear datos para asegurarse de que las ventas son numéricas
            data.forEach((d) => (d.ventas = +d.ventas));

            // Escalas
            const xScale = d3
                .scaleBand()
                .domain(data.map((d) => d.mes))
                .range([0, width - margin.left - margin.right])
                .padding(0.1);

            const yScale = d3
                .scaleLinear()
                .domain([0, d3.max(data, (d) => d.ventas)])
                .nice()
                .range([height - margin.top - margin.bottom, 0]);

            // Ejes
            const xAxis = d3.axisBottom(xScale);
            const yAxis = d3.axisLeft(yScale);

            // Agregar título al gráfico
            svg.append("text")
                .attr("text-anchor", "middle")
                .attr("x", (width - margin.left - margin.right) / 2)
                .attr("y", -20)
                .attr("class", "chart-title")
                .text(`Histórico de Ventas por Mes en ${local || "Todos los locales"}`);

            // Dibujar ejes
            svg.append("g")
                .attr("transform", `translate(0, ${height - margin.top - margin.bottom})`)
                .call(xAxis)
                .attr("font-size", "12px");

            // Título del eje X
            svg.append("text")
                .attr("text-anchor", "middle")
                .attr("x", (width - margin.left - margin.right) / 2 + margin.left)
                .attr("y", height - margin.bottom + 40)
                .attr("class", "axis-title")
                .text("Meses");

            svg.append("g").call(yAxis).attr("font-size", "12px");

            // Título del eje Y
            svg.append("text")
                .attr("text-anchor", "middle")
                .attr("transform", "rotate(-90)")
                .attr("x", -(height - margin.top - margin.bottom) / 2 - margin.top)
                .attr("y", -margin.left + 20)
                .attr("class", "axis-title")
                .text("Ventas");

            // Línea
            const line = d3
                .line()
                .x((d) => xScale(d.mes) + xScale.bandwidth() / 2)
                .y((d) => yScale(d.ventas));

            svg.append("path")
                .datum(data)
                .attr("fill", "url(#gradient)")
                .attr("stroke", "steelblue")
                .attr("stroke-width", 2)
                .attr("d", line);

            // Puntos
            svg.selectAll(".circle")
                .data(data)
                .enter()
                .append("circle")
                .attr("cx", (d) => xScale(d.mes) + xScale.bandwidth() / 2)
                .attr("cy", (d) => yScale(d.ventas))
                .attr("r", 4)
                .attr("fill", "steelblue");
        })
        .catch((error) => {
            console.error("Error al cargar los datos:", error);
        });
}

// Cargar el gráfico al inicializar
cargarGrafico('all');


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
             
  <div class="card-body" id="doughnutChart">
  </div>

  <script src="http://d3js.org/d3.v3.min.js"></script>
  <script>
    var svg = d3.select("#doughnutChart")
      .append("svg")
      .append("g");

    svg.append("g")
      .attr("class", "slices");
    svg.append("g")
      .attr("class", "labels");
    svg.append("g")
      .attr("class", "lines");

      var container = d3.select("#doughnutChart");
var width = container.node().clientWidth/2,
    height = container.node().clientHeight/2,
    radius = Math.min(width, height) / 2;
    var pie = d3.layout.pie()
      .sort(null)
      .value(function(d) {
        return d.value;
      });

    var arc = d3.svg.arc()
      .outerRadius(radius * 0.8)
      .innerRadius(radius * 0.4);

    var outerArc = d3.svg.arc()
      .innerRadius(radius * 0.9)
      .outerRadius(radius * 0.9);

    svg.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    var key = function(d) {
      return d.data.label;
    };

    var color = d3.scale.ordinal()
      .domain(["Lorem ipsum", "dolor sit", "amet", "consectetur", "adipisicing", "elit", "sed", "do", "eiusmod", "tempor", "incididunt"])
      .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

    function randomData() {
      var labels = color.domain();
      return labels.map(function(label) {
        return { label: label, value: Math.random() }
      });
    }

    change(randomData());

    d3.select(".randomize")
      .on("click", function() {
        change(randomData());
      });

    function change(data) {

      /* ------- PIE SLICES -------*/
      var slice = svg.select(".slices").selectAll("path.slice")
        .data(pie(data), key);

      slice.enter()
        .insert("path")
        .style("fill", function(d) { return color(d.data.label); })
        .attr("class", "slice");

      slice
        .transition().duration(1000)
        .attrTween("d", function(d) {
          this._current = this._current || d;
          var interpolate = d3.interpolate(this._current, d);
          this._current = interpolate(0);
          return function(t) {
            return arc(interpolate(t));
          };
        })

      slice.exit()
        .remove();

      /* ------- TEXT LABELS -------*/

      var text = svg.select(".labels").selectAll("text")
        .data(pie(data), key);

      text.enter()
        .append("text")
        .attr("dy", ".35em")
        .text(function(d) {
          return d.data.label;
        });

      function midAngle(d) {
        return d.startAngle + (d.endAngle - d.startAngle) / 2;
      }

      text.transition().duration(1000)
        .attrTween("transform", function(d) {
          this._current = this._current || d;
          var interpolate = d3.interpolate(this._current, d);
          this._current = interpolate(0);
          return function(t) {
            var d2 = interpolate(t);
            var pos = outerArc.centroid(d2);
            pos[0] = radius * (midAngle(d2) < Math.PI ? 1 : -1);
            return "translate(" + pos + ")";
          };
        })
        .styleTween("text-anchor", function(d) {
          this._current = this._current || d;
          var interpolate = d3.interpolate(this._current, d);
          this._current = interpolate(0);
          return function(t) {
            var d2 = interpolate(t);
            return midAngle(d2) < Math.PI ? "start" : "end";
          };
        });

      text.exit()
        .remove();

      /* ------- SLICE TO TEXT POLYLINES -------*/

      var polyline = svg.select(".lines").selectAll("polyline")
        .data(pie(data), key);

      polyline.enter()
        .append("polyline");

      polyline.transition().duration(1000)
        .attrTween("points", function(d) {
          this._current = this._current || d;
          var interpolate = d3.interpolate(this._current, d);
          this._current = interpolate(0);
          return function(t) {
            var d2 = interpolate(t);
            var pos = outerArc.centroid(d2);
            pos[0] = radius * 0.95 * (midAngle(d2) < Math.PI ? 1 : -1);
            return [arc.centroid(d2), outerArc.centroid(d2), pos];
          };
        });

      polyline.exit()
        .remove();
    };
  </script> 

                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>