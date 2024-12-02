<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../../config/conexion.php");

if(!isset($_SESSION['usuario'])){
    header('Location: ../login.php');
}

if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../../components/navbaruser.php';
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Venta de Auto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            background: #E6E6E6;
            min-height: 100vh;
        }

        .container-form {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            padding-left: 0px;
        }


        .step-indicator {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .step-indicator span {
            color: #aaa;
            margin-right: 20px;
        }

        .step-indicator span.active {
            color: black;
        }

        .form-group label {
            font-weight: bold;
        }

        .section {
            display: none;
        }

        .active-section {
            display: block;
        }

        .banner {
            position: relative;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                            url('../../src/images/venta-banner.jpg'); 
            background-size: cover;
            background-position: center 90%;
            height: 30vh; 
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 1;
            text-align: center;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }

        .banner h1 {
            font-size: 2rem; 
            margin: 0;
        }

        .banner h2 {
            font-size: 1rem; 
            font-weight: 300;
            margin: 0;
        }
    </style>
</head>

<body class="pt-5 mt-5">
    <div class="container banner">
        <h1 class="text-white">Vende tu Auto con Confianza</h1>
        <h2>Obtén la mejor oferta de manera rápida y segura. Nosotros nos encargamos del resto.</h2>
    </div>
    <div class="container mt-2">
        <div class="mt-1 pt-5 mb-5">
            <div class="step-indicator">
                <span id="step-1" class="active">01 | Propietario</span>
                <span id="step-2">02 | Vehículo</span>
                <span id="step-3">03 | Documentos</span>
            </div>

            <!-- Sección 1: Tus datos -->
            <div id="section-1" class="section active-section">
                <h2 class="mb-4">Datos del Propietario</h2>
                <form id="form-datos" method="POST">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nombre">Nombre Dueño</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="rut">RUT Dueño</label>
                            <input type="text" class="form-control" id="rut" name="rut" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="correo">Correo Dueño</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" class="form-control" id="telefono" name="telefono" min="100000000"
                            max="999999999" required placeholder="+569">
                    </div>
                    <div class="form-group mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="aceptar_terminos1" required>
                            <label class="form-check-label" for="aceptar_terminos1">
                                Autorizo de manera libre y voluntaria para que mis datos personales sean tratados y
                                usados para ser contactado.
                            </label>
                        </div>
                    </div>

                    <button type="button" class="btn btn-dark mt-4" onclick="nextSection(2, 'form-datos')">Confirmar
                        datos</button>
                </form>
            </div>

            <!-- Sección 2: Modelo -->
            <div id="section-2" class="section">
                <h2 class="mb-4">Datos del Vehículo</h2>
                <form id="form-modelo" method="POST">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="marca">Marca Vehículo</label>
                            <input type="text" class="form-control" id="marca" name="marca" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="modelo">Nombre Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="anio">Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" required>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="pais">Pais de Origen</label>
                            <input type="text" class="form-control" id="pais" name="pais" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="kilometraje">Kilometraje</label>
                            <input type="number" class="form-control" id="kilometraje" name="kilometraje" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-dark mt-4"
                        onclick="nextSection(3, 'form-modelo')">Continuar</button>
                </form>
            </div>

            <!-- Sección 3: Sucursal -->
            <div id="section-3" class="section">
                <h2 class="mb-4">Docuemntos e Imagenes</h2>
                <form id="form-media" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="patente">PATENTE</label>
                                <input type="text" class="form-control" id="patente" name="patente" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="doc_propiedad">Documento de Propiedad</label>
                                <input type="file" class="form-control" id="doc_propiedad" name="doc_propiedad"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="imagen">Imagen del Vehículo</label>
                                <input type="file" class="form-control" id="imagen" name="imagen"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="precio">Precio Estimado (Será usado de referencia)</label>
                                <input type="number" class="form-control" id="precio" name="precio" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark mt-4">Confirmar Solicitud</button>
                </form>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php
    include("../../components/footer.php")
?>
</body>

</html>
<script>
    // Función para combinar los datos de varios formularios
    function mergeFormData(...forms) {
        const combinedFormData = new FormData();
        forms.forEach(form => {
            const formData = new FormData(form);
            formData.forEach((value, key) => {
                combinedFormData.append(key, value);
            });
        });
        return combinedFormData;
    }

    document.getElementById("form-media").addEventListener("submit", function (event) {
        event.preventDefault();

        // Combinar datos de los tres formularios en un solo FormData
        const combinedFormData = mergeFormData(
            document.getElementById("form-datos"),
            document.getElementById("form-modelo"),
            document.getElementById("form-media")
        );

        fetch("guardar_solicitud_venta.php", {
            method: "POST",
            body: combinedFormData
        })
            .then(response => response.text())
            .then(data => {
                console.log("Respuesta del servidor:", data);
                window.location.href = 'mis_solicitudes.php';
            })
            .catch(error => console.error("Error:", error));
    });
</script>
<script>
    function nextSection(section, formId) {
        // Validar el formulario actual
        const form = document.getElementById(formId);
        if (!form.checkValidity()) {
            form.reportValidity(); // Muestra mensajes de validación si hay campos inválidos
            return;
        }

        // Ocultar todas las secciones
        document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active-section'));
        // Mostrar la siguiente sección
        document.getElementById('section-' + section).classList.add('active-section');

        // Actualizar la barra de pasos
        document.querySelectorAll('.step-indicator span').forEach(span => span.classList.remove('active'));
        document.getElementById('step-' + section).classList.add('active');
    }

</script>