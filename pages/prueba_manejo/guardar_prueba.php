<?php
session_start();
require '../../config/conexion.php';
require '../../vendor/autoload.php'; // Incluye el autoload de Composer para PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




// Datos de la solicitud
$rut_usuario = $_SESSION['rut'];
$id_sucursal = isset($_POST['sucursal']) ? $_POST['sucursal'] : null;
$rut_conductor = isset($_POST['rut']) ? $_POST['rut'] : null;
$nombre_conductor = isset($_POST['nombre']) && isset($_POST['apellido']) ? $_POST['nombre'] . ' ' . $_POST['apellido'] : null;
$correo_conductor = isset($_POST['correo']) ? $_POST['correo'] : null;
$telefono_conductor = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$vehiculo_modelo_prueba = isset($_POST['modelo']) ? $_POST['modelo'] : null;
$fecha_prueba = isset($_POST['fecha']) ? $_POST['fecha'] : null;
$hora_prueba = isset($_POST['hora']) ? $_POST['hora'] : null;


if ($id_sucursal && $rut_conductor && $nombre_conductor &&
    $correo_conductor && $telefono_conductor && $vehiculo_modelo_prueba &&
    $fecha_prueba && $hora_prueba) {

    // Obtener el nombre del modelo del vehículo
    $query_modelo = "SELECT nombre_modelo FROM vehiculo WHERE id_vehiculo='$vehiculo_modelo_prueba'";
    $result_modelo = mysqli_query($conexion, $query_modelo);
    $nombre_modelo = $result_modelo && mysqli_num_rows($result_modelo) > 0 
        ? mysqli_fetch_assoc($result_modelo)['nombre_modelo'] 
        : "Modelo desconocido";

    // Obtener el nombre de la sucursal
    $query_sucursal = "SELECT nombre_sucursal FROM sucursal WHERE id_sucursal='$id_sucursal'";
    $result_sucursal = mysqli_query($conexion, $query_sucursal);
    $nombre_sucursal = $result_sucursal && mysqli_num_rows($result_sucursal) > 0 
        ? mysqli_fetch_assoc($result_sucursal)['nombre_sucursal'] 
        : "Sucursal desconocida";

    // inserta en la base de datos
    $sql = "INSERT INTO agenda_prueba (id_sucursal, rut_usuario, rut_conductor, nombre_conductor, correo_conductor, telefono_conductor, vehiculo_modelo_prueba, fecha_prueba, hora_prueba) 
            VALUES ('$id_sucursal', '$rut_usuario', '$rut_conductor', '$nombre_conductor', '$correo_conductor', '$telefono_conductor', '$vehiculo_modelo_prueba', '$fecha_prueba', '$hora_prueba')";

    if (mysqli_query($conexion, $sql)) {
        // Configura el correo usando PHPMailer
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'renzomotors08@gmail.com';
            $mail->Password = 'lhkxtvloaecotvea';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('renzomotors08@gmail.com', 'RenzoMotors');
            $mail->addAddress($correo_conductor, $nombre_conductor); 
            $mail->CharSet = 'UTF-8'; 


            $mail->isHTML(true); 
            $mail->Subject = 'Confirmación de Prueba de Manejo';
            $mail->Body = ''; 
            $mail->Body = "
                <h3>Estimado(a) $nombre_conductor,</h3>
                <p>Su solicitud para la prueba de manejo ha sido registrada exitosamente. A continuación, los detalles:</p>
                <ul>
                    <li><strong>Sucursal:</strong> $nombre_sucursal</li>
                    <li><strong>Modelo de Vehículo:</strong> $nombre_modelo</li>
                    <li><strong>Fecha:</strong> $fecha_prueba</li>
                    <li><strong>Hora:</strong> $hora_prueba</li>
                </ul>
                <p>Si tiene alguna pregunta, no dude en contactarnos.</p>
                <p>Saludos,<br>Equipo de Atención al Cliente.</p>
            ";


            // Envía el correo
            $mail->send();
            echo "<script>
                    alert('Solicitud de prueba de manejo enviada correctamente. También se ha enviado un correo de confirmación.');
                    window.location.href='test_manejo.php?mensaje=confirmacion';
                  </script>";
        } catch (Exception $e) {
            echo "La solicitud se guardó correctamente, pero ocurrió un error al enviar el correo: {$mail->ErrorInfo}";

        }
    } else {
        echo "Error en la inserción: " . mysqli_error($conexion);

    }
} else {
    echo "Error: Algunos datos no fueron recibidos.";
    var_dump(
        $_POST['sucursal'],
        $_POST['rut'],
        $_POST['nombre'],
        $_POST['correo'],
        $_POST['telefono'],
        $_POST['modelo'],
        $_POST['fecha'],
        $_POST['hora']
    );

}
?>
