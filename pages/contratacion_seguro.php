<?php
session_start();
include('../config/conexion.php');

// Verificación de usuario
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}



?>


<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Contración seguro</title>
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
            <form action='' method="POST" enctype="multipart/form-data">

                <!-- Selector para elegir si es para el usuario actual o para un tercero -->
                <div class="form-group mb-3">
                    <label class="form-label">¿La reserva es para usted o para un tercero?</label>
                    <select class="form-select" id="reservation_for" required onchange="togglePersonalInfo()">
                        <option value="self">Para mí</option>
                        <option value="third_party">Para un tercero</option>
                    </select>
                </div>

                <!-- Campos de información personal -->
                <div id="personal_info">
                    <div class="form-group mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" name="rut" class="form-control" id="rut"
                            placeholder="Rut sin puntos y con dígito verificador" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre Completo"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" id="correo"
                            placeholder="ejemplo@mail.com" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telefono" class="form-label">Número Telefónico</label>
                        <input type="number" name="telefono" class="form-control" id="telefono" placeholder="569..."
                            required>
                    </div>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-custom">Pagar Seguro</button>
                </div>
            </form>




        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Datos del usuario para autocompletar
        const userData = {
            nombre: "<?php echo $_SESSION['nombre'] ?? ''; ?>",
            correo: "<?php echo $_SESSION['correo'] ?? ''; ?>",
            rut: "<?php echo $_SESSION['rut'] ?? ''; ?>"
        };

        function togglePersonalInfo() {
            const reservationFor = document.getElementById('reservation_for').value;
            const personalInfoDiv = document.getElementById('personal_info');

            if (reservationFor === 'self') {
                // Autocompletar datos del usuario
                document.getElementById('nombre').value = userData.nombre;
                document.getElementById('correo').value = userData.correo;
                document.getElementById('rut').value = userData.rut;
            } else {
                // Limpiar los campos para un tercero
                document.getElementById('nombre').value = '';
                document.getElementById('correo').value = '';
                document.getElementById('rut').value = '';
            }
        }

        // Ejecutar al cargar la página para el valor predeterminado (para mí)
        togglePersonalInfo();
    </script>


</body>

</html>