<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require('./ventas/queries.php');
include($_SERVER['DOCUMENT_ROOT'] . "/xampp/renzomotors/config/conexion.php");

if (isset($_SESSION['usuario'])) {
  if ($_SESSION['tipo_persona'] === 'administrador') {

    $rut_user = $_SESSION['rut'];
    $permisos = "SELECT p.* FROM permiso p
                                 JOIN rol_permiso rp ON rp.id_permiso = p.id_permiso
                                 JOIN rol r ON r.id_rol = rp.id_rol
                                 JOIN administrador a ON a.id_rol = r.id_rol
                                 WHERE a.rut_administrador = '$rut_user'";
    $result_permisos = $conexion->query($permisos);
    $lista_permisos = [];
    while ($permiso = $result_permisos->fetch_assoc()) {
      $lista_permisos[] = $permiso['nombre_permiso'];
    }

    if (in_array('Ventas', $lista_permisos)) {
      include($_SERVER['DOCUMENT_ROOT'] . "/xampp/renzomotors/admin/navbaradmin.php");
    } else {
      header('Location: dashboard.php');
    }
  } else {
    header('Location: ../../../index.php');
  }
} else {
  header('Location: ../../../pages/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

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
  <?php include __DIR__ . "/../../admin/navbaradmin.php"; ?>
  <div class="container-fluid p-5">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
      <h3 class="text-dark mb-0">Analisis de Ventas
        <a href='ventas/confirmacion_ventas.php' class='btn btn-success btn-sm d-none d-sm-inline-block mx-auto' title='Ver Ventas'>Concretar Ventas</a>
        <a class="btn btn-primary btn-sm d-none d-sm-inline-block mx-auto" role="button"
          href="../../utils/Exportacion_informe_venta.php"><i class="fas fa-download fa-sm text-white-50"></i> Generar
          Reporte</a>

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
                <div class="text-dark fw-bold h5 mb-0"><span>$<?php echo ContadorVentaTotalAccesorios(); ?> </span>
                </div>
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
                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Reservas concretadas:
                    <?php
                    echo $reservas_concretadas;
                    ?></span></div>

                <div class="progress-container mb-4">

                  <div class="progress">

                    <div class="progress-bar bg-primary" role="progressbar" style="width:<?php
                    echo $porcentaje_reservas_concretadas;
                    ?>%;" aria-valuenow="
                                                                                                                <?php
                                                                                                                echo $porcentaje_reservas_concretadas;
                                                                                                                ?>"
                      aria-valuemin="0" aria-valuemax="100">
                      <?php
                      echo $porcentaje_reservas_concretadas;
                      ?>%
                    </div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php
                    echo $porcentaje_reservas_no_concretadas;
                    ?>%;" aria-valuenow="<?php
                    echo $porcentaje_reservas_no_concretadas;
                    ?>" aria-valuemin="0" aria-valuemax="100">
                      <?php
                      echo $porcentaje_reservas_no_concretadas;
                      ?>%
                    </div>
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
            <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false"
                data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
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
  const apiUrl = `./ventas/chartAjax.php?local=${local}`;

  // Usar Fetch para hacer la petición AJAX
  fetch(apiUrl)
    .then(response => response.json()) // Parsear el JSON de la respuesta
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
        .text(`Histórico de Ventas por Mes en ${local && local !== 'all' ? local : "Todos los locales"}`);

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
            <div class="dropdown no-arrow">
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

          <div class="card-body" id="donutDiv" style='min-height:42vh;'>
          </div>
                <script>

                  // Función para cargar los datos y renderizar el gráfico
async function cargarGraficoTorta() {
  const container = d3.select("#donutDiv");
  const width = container.node().clientWidth;
  const height = container.node().clientHeight;
  const margin = { top: 20, right: 20, bottom: 20, left: 20 };
  const radius = Math.min(width, height) / 2 - margin.top;

  // Limpiar el contenedor antes de renderizar el gráfico
  container.selectAll("*").remove();

  // Crear el SVG principal
  const svg = container
    .append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", `translate(${width / 2}, ${height / 2})`);

  // Crear el arco de la torta
  const arc = d3.arc()
    .outerRadius(radius)
    .innerRadius(radius - 50); // Radio del "donut"

  // Crear el arco de las etiquetas (en el centro de cada sección)
  const labelArc = d3.arc()
    .outerRadius(radius - 30)
    .innerRadius(radius - 30);

  // Crear el color scale
  const color = d3.scaleOrdinal(d3.schemeCategory10);

  // Función para cargar y actualizar los datos desde la API
  async function cargarDatos() {
    try {
      const response = await fetch("./ventas/donutAjax.php");
      const data = await response.json();

      // Asegurarse que los datos sean correctos y formatearlos
      data.forEach(d => {
        d.reservas_concretadas = +d.reservas_concretadas; // Convertir a número
      });

      // Crear el pie chart
      const pie = d3.pie()
        .value(d => d.reservas_concretadas)
        .sort(null); // Para mantener el orden original

      const pieData = pie(data);

      // Generar las secciones del gráfico
      const arcs = svg
        .selectAll(".arc")
        .data(pieData)
        .enter()
        .append("g")
        .attr("class", "arc");

      arcs
        .append("path")
        .attr("d", arc)
        .attr("fill", (d, i) => color(i));

      // Añadir las etiquetas al gráfico
      arcs
        .append("text")
        .attr("transform", d => `translate(${labelArc.centroid(d)})`)
        .attr("dy", ".35em")
        .attr("text-anchor", "middle")
        .text(d => d.data.nombre_sucursal);

    } catch (error) {
      console.error("Error al cargar los datos:", error);
    }
  }

  // Cargar los datos inicialmente
  cargarDatos();

  // Actualizar los datos periódicamente (cada 10 segundos en este caso)
  setInterval(cargarDatos, 10000); // Ajusta el tiempo según tus necesidades
}

// Llamar a la función para cargar el gráfico
cargarGraficoTorta();

                </script>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>