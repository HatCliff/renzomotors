<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurar contraseña</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>
<body style='height:100vh;' class="d-flex align-items-center justify-content-center" data-bs-theme="dark">
  <script type="module">
    import { evaluarstrength } from "./../src/js/validators.js";
    window.evaluarstrength = evaluarstrength;
  </script>
    <form action="./../auth/recover.php" class="form mb-3 border py-5 px-5">
        <div class="mb-3">
            <h3>Renzo Motors</h3>
            <label for="" class="form-label">Contraseña nueva:</label>
            <input
                type="password"
                name="new_password"
                id="new_password"
                class="form-control"
                placeholder="Escriba aquí su nueva contraseña."
                aria-describedby="helpId"
                onkeyup="evaluarstrength(this);"
            />
            <div class="progress">
                <div class="progress-bar  bg-${2|success,info,success,warning,wardanger}}" role="progressbar" style="width: 0%;"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ${6| ,progress-bar-animated}>weak</div>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Repetir contraseña nueva:</label>
            <input
                type="password"
                class="form-control"
                name="repeat_new_password"
                id="repeat_new_password"
                placeholder="Contraseña nueva..."
            />
        </div>
        <input type="submit" value="Restablecer contraseña" class="btn btn-primary">
    </form>
</body>
</html>