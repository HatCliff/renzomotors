<?php
function success($yes, $message) {
    $icon = $yes ? "bi bi-check-circle-fill text-success" : "bi bi-x-circle-fill text-danger";
    $status = $yes ? "Aprobado" : "Rechazado";
    $alertClass = $yes ? "alert-success" : "alert-danger";
    echo "
    <!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Estado de Reserva</title>
    <!-- Bootstrap CSS CDN -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet' crossorigin='anonymous'>
    <!-- Bootstrap Icons CDN -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
</head>
    <div class='d-flex justify-content-center align-items-center vh-100'>
        <div class='card text-center p-4' style='width: 18rem;'>
            <div class='card-body'>
                <i class='$icon' style='font-size: 2rem;'></i>
                <h1 class='card-title mt-2'>$status</h1>
                <p class='card-text'>$message</p>
                <a href='http://localhost/xampp/renzomotors' class='btn btn-primary'>Volver</a>
            </div>
        </div>
    </div>
    ";
}

function error($code, $message) {
    // Establece las variables de sesión
    $_SESSION['error_code'] = $code;
    $_SESSION['error'] = $message;

    // Comprueba si se solicitó limpiar las variables de sesión
    if (isset($_POST['clear_error'])) {
        unset($_SESSION['error_code']);
        unset($_SESSION['error']);
    }

    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error</title>
        <!-- Bootstrap CSS CDN -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet' crossorigin='anonymous'>
    </head>
    <body>
    
        <div class='mx-auto fcol-3 fixed-top alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Error $code:</strong> $message
            <form method='post' style='display:inline;'>
                <button type='submit' name='clear_error' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </form>
        </div>  

    <!-- Bootstrap JS CDN -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js' crossorigin='anonymous'></script>
    </body>
    </html>
    ";
}

?>