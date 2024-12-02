<?php
session_start();
include("../../config/conexion.php");    
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    header("Location: ../../pages/login.php");
    exit();
}
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <style>
        main{
            flex:1;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #E6E6E6;
        }
        .container-form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
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
                            url('../../src/images/seguro_soap_card.jpg'); 
            background-size: cover;
            background-position: center 30%;
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

<body>
<main class="pt-5 mt-5">
    <div class="container banner">
        <h1 class="text-white">Obtén tu SOAP con RenzoMotors</h1>
        <h2>Adquiere tu Seguro Obligatorio de Accidentes Personales (SOAP) fácil y rápido, y prepárate para circular seguro en las calles de Chile.</h2>
    </div>
<div class="container mt-2 ">
    <div class=" mt-1 pt-5 mb-5">
        <div class="step-indicator">
            <span id="step-1" class="active">01 | Tu Patente</span>
            <span id="step-2">02 | Datos del Vehículo</span>
            <span id="step-3">03 | Pago SOAP</span>
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
                    <select class="form-control" id="tipo" name="tipo" required onchange="calcularMonto()">
                        <option value="" disabled selected>Seleccione el tipo de vehículo</option>
                        <option value="Camioneta">Camioneta</option>
                        <option value="Auto">Auto</option>
                        <option value="Motocicleta">Motocicleta</option>
                        <option value="Furgón">Furgón</option>
                        <option value="Bus">Bus</option>
                    </select>
                </div>
                <div id="monto-container" class="mt-3" style="display: none;">
                    <p class="alert alert-info">
                        <strong>Monto a pagar:</strong> <span id="monto">$0</span>
                    </p>
                </div>
                <input type="hidden" id="precio" name="precio">
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
            <form action='../../auth/transaction_soap.php' id="form-pago-soap" method="POST">
                <input type="hidden" id="hidden-patente" name="patente">
                <input type="hidden" id="hidden-tipo" name="tipo">
                <input type="hidden" id="hidden-marca" name="marca">
                <input type="hidden" id="hidden-modelo" name="modelo">
                <input type="hidden" id="hidden-anio" name="anio">
                <input type="hidden" id="hidden-num_motor" name="num_motor">
                <input type="hidden" id="hidden-num_chasis" name="num_chasis">
                <input type="hidden" id="hidden-precio" name="precio">
                <div class="form-group">
                    <label for="correo_comprobante">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo_comprobante" name="correo_comprobante" placeholder="Ingrese su correo" required>
                    <small>Te enviaremos el comprobante a este Correo Electrónico</small>
                </div>
                <button type="button" class="btn btn-dark mt-4" onclick="enviarFormulario()">Finalizar y Pagar</button>
            </form>
        </div>

    </div>
    <div class="modal fade" id="avisoModal" tabindex="-1" aria-labelledby="avisoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avisoModalLabel">¡Transacción Exitosa!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tu compra del SOAP fue procesada exitosamente. Gracias por confiar en nosotros.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="right-image d-flex align-items-center justify-content-center">

    </div>

</div>
</main>
<FOOTer>
    <?php
    include("../../components/footer.php")
    ?>
</FOOTer>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
<script>
    function enviarFormulario() {
    // Obtener valores de los formularios anteriores
        const patente = document.getElementById('patente').value;
        const tipo = document.getElementById('tipo').value;
        const marca = document.getElementById('marca').value;
        const modelo = document.getElementById('modelo').value;
        const anio = document.getElementById('anio').value;
        const num_motor = document.getElementById('num_motor').value;
        const num_chasis = document.getElementById('num_chasis').value;
        const precio = document.getElementById('precio').value;

        // Pasar valores a los campos ocultos del formulario final
        document.getElementById('hidden-patente').value = patente;
        document.getElementById('hidden-tipo').value = tipo;
        document.getElementById('hidden-marca').value = marca;
        document.getElementById('hidden-modelo').value = modelo;
        document.getElementById('hidden-anio').value = anio;
        document.getElementById('hidden-num_motor').value = num_motor;
        document.getElementById('hidden-num_chasis').value = num_chasis;
        document.getElementById('hidden-precio').value = precio;

        // Validar el formulario de pago y enviarlo
        const formPago = document.getElementById('form-pago-soap');
        if (formPago.checkValidity()) {
            formPago.submit();
        } else {
            formPago.reportValidity();
        }
    }
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

    function calcularMonto() {
        const tipo = document.getElementById('tipo').value;
        const montoContainer = document.getElementById('monto-container');
        const monto = document.getElementById('monto');
        const precioInput = document.getElementById('precio'); // Campo oculto

        const tarifas = {
            "Camioneta": 30000,
            "Auto": 25000,
            "Motocicleta": 15000,
            "Furgón": 40000,
            "Bus": 50000
        };

        if (tipo) {
            const tarifa = tarifas[tipo];
            monto.textContent = `$${tarifa.toLocaleString('es-CL')}`;
            precioInput.value = tarifa; 
            montoContainer.style.display = 'block';
        } else {
            montoContainer.style.display = 'none';
            precioInput.value = ''; 
        }
    }
    document.addEventListener("DOMContentLoaded", function () {

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('estado') && urlParams.get('estado') === 'aprobado') {
        mostrarMensajeExito();

        history.replaceState(null, '', window.location.pathname);
    }
});

function mostrarMensajeExito() {
    const mensajeDiv = document.createElement("div");


    mensajeDiv.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 24px;">✔️</span>
            <span>¡Transacción exitosa! Tu compra del SOAP fue procesada correctamente.</span>

        
        </div>
    `;

    mensajeDiv.style.position = "fixed";
    mensajeDiv.style.top = "50%";
    mensajeDiv.style.left = "50%";
    mensajeDiv.style.transform = "translate(-50%, -50%)";
    mensajeDiv.style.backgroundColor = "#28a745"; 
    mensajeDiv.style.color = "white";
    mensajeDiv.style.padding = "20px 30px";
    mensajeDiv.style.borderRadius = "10px";
    mensajeDiv.style.fontSize = "18px";
    mensajeDiv.style.boxShadow = "0 4px 6px rgba(0, 0, 0, 0.1)";
    mensajeDiv.style.zIndex = "1000";

    document.body.appendChild(mensajeDiv);


    setTimeout(() => {
        mensajeDiv.remove();
    }, 3000);
}

</script>
</html>
