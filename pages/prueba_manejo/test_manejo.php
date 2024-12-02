<?php
session_start();
// Verificación de usuario
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    header("Location: ../../pages/login.php");
    exit();
}
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
    <title>Solicitud Test Drive</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
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
                            url('../../src/images/test_manejo.webp'); 
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

<body >
    <main class="pt-5 mt-5">
        <div class="container mt-2">
            <div class="container banner">
                <h1 class="text-white">Haz la Prueba de Manejo del auto de tus sueños</h1>
                <h2>Reserva tu prueba de manejo del auto que desees en la sucursal mas cercana a tí.</h2>
            </div>
            <div class=" mt-1 pt-5 mb-5">
                <div class="step-indicator">
                    <span id="step-1" class="active">01 | Tus datos</span>
                    <span id="step-2">02 | Modelo</span>
                    <span id="step-3">03 | Sucursal</span>
                </div>

                <!-- Sección 1: Tus datos -->
                <div id="section-1" class="section active-section">
                    <h2 class="mb-4">Tus Datos</h2>
                    <form id="form-datos" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="rut">RUT</label>
                                <input type="text" 
                                    class="form-control" 
                                    id="rut" 
                                    name="rut" 
                                    placeholder="12.345.678-9" 
                                    required 
                                    pattern="^\d{1,2}\.\d{3}\.\d{3}-[0-9kK]$" 
                                    title="Ingrese un RUT válido en el formato 12.345.678-9.">
                            
                            </div>
                            <div class="form-group col-md-6">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" 
                                class="form-control" 
                                id="telefono" 
                                name="telefono" 
                                placeholder="+569" 
                                required 
                                pattern="^\+?[0-9]{9,15}$" 
                                title="Ingrese un teléfono válido. Puede incluir el símbolo + al inicio, seguido de 9 a 15 dígitos.">
                        </div>
                        <div class="form-group mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aceptar_terminos1" required>
                                <label class="form-check-label" for="aceptar_terminos1">
                                    Autorizo que mis datos personales sean tratados y usados para ser contactado.
                                </label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-dark mt-4" onclick="nextSection(2, 'form-datos')">Confirmar datos</button>
                    </form>
                </div>


                <!-- Sección 2: Modelo -->
                <div id="section-2" class="section">
                    <h2 class="mb-4">Selecciona el Modelo</h2>
                    <form id="form-modelo" method="POST">
                        <div class="form-group">
                            <label>Marca</label>
                            <select class="form-control" id="marca" name="marca" onchange="cargarModelos()" required>
                                <option value="">Seleccione una marca</option>
                                <?php
                                $marcas = mysqli_query($conexion, "SELECT * FROM marca");
                                while ($marca = mysqli_fetch_assoc($marcas)) {
                                    $selected = ($marca_seleccionada == $marca['id_marca']) ? 'selected' : '';
                                    echo "<option value='{$marca['id_marca']}' $selected>{$marca['nombre_marca']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Modelo</label>
                            <select class="form-control" id="modelo" name="modelo" required>
                                <option value="">Seleccione un modelo</option>
                            </select>
                        </div>
                        
                        <button type="button" class="btn btn-dark mt-4" onclick="nextSection(3, 'form-modelo')">Continuar</button>
                    </form>
                </div>

                <!-- Sección 3: Sucursal -->
                <div id="section-3" class="section">
                    <h2 class="mb-4">Selecciona la Sucursal</h2>
                    <form id="form-sucursal" method="POST">
                        <div class="form-group">
                            <label>Sucursal</label>
                            <select class="form-control" id="sucursal" name="sucursal" required>
                                <?php
                                $sucursales = mysqli_query($conexion, "SELECT * FROM sucursal");
                                while ($sucursal = mysqli_fetch_assoc($sucursales)) {
                                    echo "<option value='{$sucursal['id_sucursal']}'>{$sucursal['nombre_sucursal']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <!-- Campo de selección de fecha -->
                        <div class="form-group mt-4">
                            <label for="fecha">Fecha de la Prueba</label>
                            <input type="date" id="fecha" name="fecha" class="form-control" required>
                        </div>
                        
                        <!-- Campo de selección de hora -->
                        <div class="form-group mt-4">
                            <label for="hora">Hora de la Prueba</label>
                            <select id="hora" name="hora" class="form-control" required>
                                <?php

                                $hora_inicio = strtotime("08:00");
                                $hora_fin = strtotime("14:00");
                                while ($hora_inicio <= $hora_fin) {
                                    $hora_formato = date("H:i", $hora_inicio);
                                    echo "<option value='$hora_formato'>$hora_formato</option>";
                                    $hora_inicio = strtotime('+30 minutes', $hora_inicio);
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-dark mt-4">Confirmar Solicitud</button>
                    </form>
                </div>
            </div>
        </div>


    </main>
    <?php
    include("../../components/footer.php")
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
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

document.getElementById("form-sucursal").addEventListener("submit", function(event) {
    event.preventDefault(); 

    // Combinar datos de los tres formularios en un solo FormData
    const combinedFormData = mergeFormData(
        document.getElementById("form-datos"),
        document.getElementById("form-modelo"),
        document.getElementById("form-sucursal")
    );

    // Enviar datos 
    fetch("guardar_prueba.php", {
        method: "POST",
        body: combinedFormData
    })
    .then(response => response.text())
    .then(data => {
        console.log("Respuesta del servidor:", data); 
        
        window.location.href = 'test_manejo.php?mensaje=confirmacion';
    })
    .catch(error => console.error("Error:", error));
});



// Configuración de la fecha para el campo de fecha
    document.addEventListener('DOMContentLoaded', function () {
        const fechaCampo = document.getElementById('fecha');
        const hoy = new Date();
        // Añadir 7 dias a la fecha actual
        hoy.setDate(hoy.getDate() + 7);
        const fechaMinima = hoy.toISOString().split('T')[0];
        fechaCampo.setAttribute('min', fechaMinima);
    });

    function cargarModelos() {
        // Obtener la marca seleccionada
        var marcaId = document.getElementById("marca").value;
        
        // Verificar que haya una marca seleccionada
        if (marcaId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cargar_modelos.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualizar el select de modelos con la respuesta
                    document.getElementById("modelo").innerHTML = xhr.responseText;
                }
            };
            
            xhr.send("marca=" + marcaId);
        } else {

            document.getElementById("modelo").innerHTML = "<option value=''>Seleccione un modelo</option>";
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
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('mensaje') && urlParams.get('mensaje') === 'confirmacion') {
        mostrarMensajeConfirmacion();

        
        history.replaceState(null, '', window.location.pathname);
    }

    function mostrarMensajeConfirmacion() {
    const mensajeDiv = document.createElement("div");
    

    mensajeDiv.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 24px;">✔️</span>
            <span>Solicitud de prueba de manejo enviada correctamente</span>
        </div>
    `;


    mensajeDiv.style.position = "fixed";
    mensajeDiv.style.top = "50%";
    mensajeDiv.style.left = "50%";
    mensajeDiv.style.transform = "translate(-50%, -50%)";
    mensajeDiv.style.backgroundColor = "#28a745";
    mensajeDiv.style.color = "white";
    mensajeDiv.style.padding = "20px 30px";
    mensajeDiv.style.borderRadius = "50px"; 
    mensajeDiv.style.fontSize = "18px";
    mensajeDiv.style.boxShadow = "0 4px 6px rgba(0, 0, 0, 0.1)";
    mensajeDiv.style.zIndex = "1000";

    // Añadir al documento
    document.body.appendChild(mensajeDiv);

    // Remover el mensaje después de 3 segundos
    setTimeout(() => {
        mensajeDiv.remove();
    }, 3000);
}

    

</script>
</html>

