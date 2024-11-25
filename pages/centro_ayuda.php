<?php
    include('../config/conexion.php');
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <title>Centro de Ayuda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            margin: auto;
        }

        .btn-custom {
            background-color: #448e42;
            color: #ffffff;
            font-weight: bold;
            border-radius: 5px;

        }


        .btn-custom:hover {
            background-color: #366c35;
        }
    </style>
</head>
<body class="mt-5 pt-5">
    <div class="container mt-5">
        <div class="form-container">
            <h4>Centro de Ayuda</h4>
            <form  method="POST" action="procesar_solicitud.php">
                <!--      <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9" required>
            </div>
            <div class="form-group">
                <label for="rut">RUT</label>
                <input type="text" class="form-control" id="rut" name="rut" maxlength="10" required>
            </div>-->
                <div class="mb-3">
                    <label for="tipo_atencion">Tipo de Atención</label>
                    <select class="form-control" id="tipo_atencion" name="tipo_atencion" required>
                        <option value="">Seleccione</option>
                        <option value="comentario">Comentario</option>
                        <option value="sugerencia">Sugerencia</option>
                        <option value="reclamo">Reclamo</option>
                        <option value="duda">Duda</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="asunto">Asunto</label>
                    <input type="text" class="form-control" id="asunto" name="asunto" maxlength="40" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" maxlength="200"
                        required></textarea>
                </div>
                <div class="d-flex justify-content-center  mt-4">
                <button  type="submit" class="btn btn-primary">Enviar Solicitud</button>
                </div>
                
            </form>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>