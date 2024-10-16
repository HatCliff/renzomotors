<?php
    $ENV = parse_ini_file(__DIR__ . "/../.env");
    session_start();
    if(!isset($_SESSION['usuario'])){
        header('Location: /'.$ENV['PREFIX'].'pages/login');
    }
    require_once(__DIR__ . "/../config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>RenzoMotors</title>
</head>
<body>
    <?php include __DIR__ . "/../components/navbar.php"; ?>
    <div class="container">
        <div class="col-5"> 
        <!-- Nav tabs -->
        <ul
            class="nav nav-tabs"
            id="navId"
            role="tablist"
        >
            <li class="nav-item">
                <a
                    href="#tab1Id"
                    class="nav-link active"
                    data-bs-toggle="tab"
                    aria-current="page"
                    >Tendencias</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="#tab2Id"
                    class="nav-link"
                    data-bs-toggle="tab"
                    >Tab 2</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="#tab3Id"
                    class="nav-link"
                    data-bs-toggle="tab"
                    >Tab 3</a
                >
            </li>
        </ul>
        </div>
        <!-- Tab panes -->
        <div class="col-5">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab1Id" role="tabpanel">
                    <?php
                        $query_sucursal = "SELECT * FROM sucursales";
                        
                        $result_sucursal = mysqli_query($conexion, $query_sucursal);

                        echo "<div class='card-group'>";
                        foreach($result_sucursal as $sucursal){
                            echo "<div class='card' style='width: 18rem;'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>".$sucursal['nombre_sucursal']."</h5>";
                            echo "<p class='card-text'>".$sucursal['direccion_sucursal']."</p>";
                            echo "<a href='/".$ENV['PREFIX']."/pages/sucursal.php?id=".$sucursal['id_sucursal']."' class='btn btn-primary'>Ver más</a>";
                            echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
                    ?>
                </div>
                <div class="tab-pane fade" id="tab2Id" role="tabpanel"></div>
                <div class="tab-pane fade" id="tab3Id" role="tabpanel"></div>
                <div class="tab-pane fade" id="tab4Id" role="tabpanel"></div>
            </div> 
        </div>
        
        <script>
            var triggerEl = document.querySelector("#navId a");
            bootstrap.Tab.getInstance(triggerEl).show(); // Select tab by name
        </script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
