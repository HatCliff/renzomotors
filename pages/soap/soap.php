<?php
session_start();
include("../../config/conexion.php");    

// Incluye el navbar correspondiente según el tipo de usuario
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
    <title>Registro Vehículo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container-form {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }
        .left-form {
            padding: 50px;
            width: 60%;
        }
        .right-image {
            background-image: url('../../src/images/test_manejo.webp'); /* Cambiar imagen según necesidad */
            background-size: cover;
            background-position: center;
            width: 40%;
            height: 70vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 2rem;
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

        /* Responsive Styles */
        @media (max-width: 991px) {
            .left-form, .right-image {
                width: 100%;
                height: auto;
            }
            .right-image {
                font-size: 1.5rem;
                padding: 20px;
            }
            .left-form {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .container-form {
                flex-direction: column-reverse;
            }
            .right-image {
                height: 200px;
                width: 100%;
                font-size: 1.2rem;
            }
            .left-form {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .right-image {
                height: 150px;
                font-size: 1rem;
                text-align: center;
            }
            .left-form {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid container-form">
    <div class="left-form mt-5 pt-5">
        <div class="step-indicator">
            <span id="step-1" class="active"> Tu Patente</span>
            <span id="step-2"> Datos del Vehículo</span>
            <span id="step-3"> Pago SOAP</span>
        </div>

        <!-- Sección 1: Tu Patente -->
        <div id="section-1" class="section active-section">
            <h2 class="mb-4">Tu Patente</h2>
            <form id="form-patente" method="POST">
                <div class="form-group">
                    <label for="patente">Patente</label>
                    <input type="text" 
                           class="form-control" 
                           id="patente" 
                           name="patente" 
                           placeholder="Ingrese la patente del vehículo" 
                           required 
                           pattern="[A-Z0-9]{6}" 
                           title="Ingrese una patente válida de 6 caracteres alfanuméricos.">
                </div>
                <button type="button" class="btn btn-dark mt-4" onclick="nextSection(2, 'form-patente')">Confirmar</button>
            </form>
        </div>

        <!-- Sección 2: Datos del Vehículo -->
        <div id="section-2" class="section">
            <h2 class="mb-4">Datos del Vehículo</h2>
            <form id="form-vehiculo" method="POST">
                <div class="form-group">
                    <label for="tipo">Tipo de Vehículo</label>
                    <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ej: Camioneta, Automóvil" required>
                </div>
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ej: Toyota, Ford" required>
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" required>
                </div>
                <div class="form-group">
                    <label for="anio">Año</label>
                    <input type="text" class="form-control" id="anio" name="anio" placeholder="Ej: 2020" required>
                </div>
                <div class="form-group">
                    <label for="num_motor">Número de Motor</label>
                    <input type="text" class="form-control" id="num_motor" name="num_motor" required>
                </div>
                <div class="form-group">
                    <label for="num_chasis">Número de Chasis</label>
                    <input type="text" class="form-control" id="num_chasis" name="num_chasis" required>
                </div>
                <button type="button" class="btn btn-dark mt-4" onclick="nextSection(3, 'form-vehiculo')">Continuar</button>
            </form>
        </div>

        <!-- Sección 3: Pago SOAP -->
        <div id="section-3" class="section">
            <h2 class="mb-4">Pago SOAP</h2>
            <p>Esta sección será implementada más adelante.</p>
            <button type="submit" class="btn btn-dark mt-4">Finalizar</button>
        </div>
    </div>

    <div class="right-image">

    </div>
</div>

<script>
    function nextSection(section, formId) {
        const form = document.getElementById(formId);
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active-section'));
        document.getElementById('section-' + section).classList.add('active-section');
        document.querySelectorAll('.step-indicator span').forEach(span => span.classList.remove('active'));
        document.getElementById('step-' + section).classList.add('active');
    }
</script>
</body>
</html>
