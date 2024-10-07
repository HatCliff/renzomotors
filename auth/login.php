<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>
<body class="container-fluid">
    <div class="mx-auto" style="width: 200px;">
        <div class="mb-3">

            <div class="input-group">
                <span class="input-group-text"><label for="" class="form-label">C</label></span>
                <input
                    type="text"
                    class="form-control"
                    name=""
                    id=""
                    aria-describedby="helpId"
                    placeholder="Correo electrónico"
                />
            </div>
            <div class="input-group">    
                <span class="input-group-text"><label for="" class="form-label"><img src="./../icons/lock.svg" alt="Contraseña" width="10px"></label></span>
                    <input
                        type="password"
                        class="form-control"
                        name=""
                        id=""
                        aria-describedby="helpId"
                        placeholder="Contraseña"
                    />
            </div>
            <small id="helpId" class="form-text text-muted">Help text</small>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
