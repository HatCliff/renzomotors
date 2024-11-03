<?php
include('../config/conexion.php');
include('../components/navbaruser.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $precio = 0;

    $fotos_query = "SELECT * FROM fotos_vehiculo WHERE id_vehiculo = $id LIMIT 1";
    $fotos_result = mysqli_query($conexion, $fotos_query);
    while ($foto = mysqli_fetch_assoc($fotos_result)) {
        $ruta = '../admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
    }
}
?>
<?php
                        $modelo_query = "SELECT nombre_modelo, precio_modelo FROM vehiculo WHERE id_vehiculo = '$id'";
                        $modelos = mysqli_query($conexion, $modelo_query);
                        $render = '';
                        while ($modelo = mysqli_fetch_assoc($modelos)) {
                            $precio = $modelo['precio_modelo'] * 0.01;
                            $render = "
                                <h4>
                                    " . $modelo['nombre_modelo'] . "
                                </h4>
                                <p class='fs-6 fw-light fst-italic'> *Cuota de reserva:
                                    " . number_format($precio, 0, ',', '.') . "
                                </p>
                                <input type='hidden' name='precio' value='" . $precio . "'>
                            ";
                        }
                        $colores = mysqli_query($conexion, "SELECT * FROM color c
                                                                              JOIN color_vehiculo cv ON c.id_color = cv.id_color
                                                                              WHERE cv.id_vehiculo = '$id'");
                            while ($color = mysqli_fetch_assoc($colores)) {
                            $render_color = "
                            <div class='form-check form-check-inline mx-auto px-0'>
                                    <input required class='form-check-input' type='radio' name='color' value='{$color['id_color']}' id='color_{$color['id_color']} required>
                                    <label class='form-check-label' for='color_{$color['id_color']}' style='background-color: {$color['codigo_color']}; padding: 20px; color: #fff;'></label>
                            </div>
                            ";
                            }
                        ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reserva Vehículo</title>
</head>

<body class="pt-5"
    style='background-image: url("<?php echo $ruta; ?>"); background-size: cover; background-position: center;'>
    <div class="container mt-5">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-7 col-sm-11 bg-white px-5 py-2 rounded">
                <form action='./../auth/transaction.php' method="POST" enctype="multipart/form-data">
                    <div class="text-center">
                        <?php echo $render; ?>
                    </div>

                    <input type="hidden" name="id_vehiculo" value="<?php echo $id; ?>">
                    <div class="form-group mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" name="rut" class="form-control" id="rut"
                            placeholder="Rut sin puntos y con digito verificador" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="NombreCliente"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="correo" class="form-label">Correo electronico</label>
                        <input type="email" name="correo" class="form-control" id="correo"
                            placeholder="ejemplo@mail.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="telefono" class="form-label">Numero telefononico</label>
                        <input type="number" name="telefono" class="form-control" id="telefono" placeholder="569..."
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Personaliza tu vehículo: </label>
                        <div class="form-check d-flex justify-content-center px-0">
                            <?php
                                echo $render_color;
                            ?>
                        </div>
                    </div>

                    <div class='mb-3'>
                        <label for='id_sucursal' class='form-label'>Seleccione una sucursal: </label>
                        <select class='form-select' name='id_sucursal' required>;
                            <?php
                            $disponible = mysqli_query($conexion, "SELECT vs.*, su.nombre_sucursal 
                                                                            FROM vehiculo_sucursal vs
                                                                            JOIN sucursal su ON su.id_sucursal = vs.id_sucursal
                                                                            WHERE vs.id_vehiculo = '$id'");
                            while ($disp = mysqli_fetch_assoc($disponible)) {
                                echo '<option value=\'' . $disp['id_sucursal'] . '\'>' . $disp['nombre_sucursal'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn text-white" style="background-color: #448e42;">Pagar
                            Reserva</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
