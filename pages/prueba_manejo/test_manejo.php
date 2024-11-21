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
    <title>Solicitud Test Drive</title>
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
            padding-left: 0px;
        }
        .left-image {
            background-image: url('../../src/images/test_manejo.jpeg'); 
            background-size: cover;
            background-position: center;
            width: 40%;
            height: 100vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 2rem;
        }
        .right-form {
            padding: 50px;
            width: 60%;
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
            .left-image, .right-form {
                width: 100%;
                height: auto;
            }
            .left-image {
                font-size: 1.5rem;
                padding: 20px;
            }
            .right-form {
                padding: 30px;
            }
        }
        
        @media (max-width: 768px) {
            .container-form {
                flex-direction: column;
                padding-right: 0px;
            }
            .left-image {
                height: 200px;
                width: 100%;
                font-size: 1.2rem;
            }
            .right-form {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .left-image {
                height: 150px;
                font-size: 1rem;
                text-align: center;
            }
            .right-form {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid container-form">
    <div class="left-image">
        <div>
            Solicita Ahora<br>
            Tu Test Drive
        </div>
    </div>
    <div class="right-form mt-5 pt-5">
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
                        <input type="text" class="form-control" id="rut" name="rut" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required placeholder="+569">
                </div>

                <div class="form-group mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="aceptar_terminos1" required>
                        <label class="form-check-label" for="aceptar_terminos1">
                            Autorizo de manera libre y voluntaria para que mis datos personales sean tratados y usados para ser contactado.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="aceptar_terminos2" required>
                        <label class="form-check-label" for="aceptar_terminos2">
                            Autorizo de manera libre y voluntaria a la Compañía para la recolección y almacenamiento de mis datos personales.
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
                        <!-- Los modelos se cargarán aquí con AJAX -->
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
                        // Horas de 8:00 a 14:00 en intervalos de 30 minutos
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

document.getElementById("form-sucursal").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el recargo de la página

    // Combinar datos de los tres formularios en un solo FormData
    const combinedFormData = mergeFormData(
        document.getElementById("form-datos"),
        document.getElementById("form-modelo"),
        document.getElementById("form-sucursal")
    );

    // Enviar datos usando fetch API
    fetch("guardar_prueba.php", {
        method: "POST",
        body: combinedFormData
    })
    .then(response => response.text())
    .then(data => {
        console.log("Respuesta del servidor:", data); // Muestra la respuesta del servidor
        // Redirecciona o cambia de sección si es necesario
        window.location.href = 'test_manejo.php';
    })
    .catch(error => console.error("Error:", error));
});


</script>
<script>
    // Configuración de la fecha mínima para el campo de fecha
    document.addEventListener('DOMContentLoaded', function () {
        const fechaCampo = document.getElementById('fecha');
        const hoy = new Date();
        // Añadir 7 días a la fecha actual
        hoy.setDate(hoy.getDate() + 7);
        // Formato YYYY-MM-DD para el campo de fecha mínima
        const fechaMinima = hoy.toISOString().split('T')[0];
        fechaCampo.setAttribute('min', fechaMinima);
    });
</script>
<script>
    function cargarModelos() {
        // Obtener la marca seleccionada
        var marcaId = document.getElementById("marca").value;
        
        // Verificar que haya una marca seleccionada
        if (marcaId) {
            // Crear una solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cargar_modelos.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualizar el select de modelos con la respuesta
                    document.getElementById("modelo").innerHTML = xhr.responseText;
                }
            };
            
            // Enviar el id de la marca seleccionada al servidor
            xhr.send("marca=" + marcaId);
        } else {
            // Si no hay marca seleccionada, vaciar el select de modelos
            document.getElementById("modelo").innerHTML = "<option value=''>Seleccione un modelo</option>";
        }
    }
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
    // Mostrar un mensaje centrado al confirmar la solicitud
    function mostrarMensajeConfirmacion() {
        const mensajeDiv = document.createElement("div");
        mensajeDiv.innerHTML = "Solicitud de prueba de manejo enviada correctamente";
        mensajeDiv.style.position = "fixed";
        mensajeDiv.style.top = "50%";
        mensajeDiv.style.left = "50%";
        mensajeDiv.style.transform = "translate(-50%, -50%)";
        mensajeDiv.style.backgroundColor = "#28a745";
        mensajeDiv.style.color = "white";
        mensajeDiv.style.padding = "20px";
        mensajeDiv.style.borderRadius = "8px";
        mensajeDiv.style.fontSize = "18px";
        mensajeDiv.style.zIndex = "1000";

        document.body.appendChild(mensajeDiv);

        setTimeout(() => {
            mensajeDiv.remove();
        }, 3000);
    }

</script>
