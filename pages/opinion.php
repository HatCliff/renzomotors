<?php

$error_message = '';
$rut = $_SESSION['rut'] ?? ''; 

$showButton = true;  // Variable que controla la visibilidad del botón

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    $error_message = "Debe iniciar sesión para escribir una opinión.";
    $showButton = false;
} else {
    $rut = $_SESSION['usuario']['rut'];
    
    // Verificar si ya existe una opinión para este vehículo del mismo usuario
    $query_check = "SELECT * FROM opinion_vehiculo WHERE rut = '$rut' AND id_vehiculo = '$idRecibida'";
    $resultado_check = mysqli_query($conexion, $query_check);

    if (mysqli_num_rows($resultado_check) > 0) {
        $error_message = "Ya has registrado una reseña para este vehículo.";
        $showButton = false;
    } else {
        // Verificar si el usuario ha comprado el vehículo y la compra está concretada
        $query_compra_check = "SELECT * FROM reserva_vehiculo 
                               JOIN registro_reserva ON reserva_vehiculo.num_reserva_vehiculo = reserva_vehiculo.num_reserva_vehiculo
                               WHERE rut_cliente = '$rut' AND id_vehiculo = '$idRecibida' AND rut='$rut'
                               AND compra_concretada = 1";
                               
        $resultado_compra_check = mysqli_query($conexion, $query_compra_check);

        if (mysqli_num_rows($resultado_compra_check) == 0) {
            // Si no se encuentra una compra concretada, mostrar mensaje de error
            $error_message = "La compra no está concretada todavia.";
            $showButton = false;
        } else {
            // Procesar el formulario en el servidor solo si todo está validado
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $rating = $_POST['rating'] ?? 0;
                $titulo = $_POST['titulo'] ?? '';
                $resenia = $_POST['resenia'] ?? '';
                $anonimo = isset($_POST['anonimo']) ? 1 : 0;
                $fecha = date('Y-m-d');

                $query = "INSERT INTO opinion_vehiculo (id_vehiculo, rut, titulo_resenia, resenia, fecha_resenia, anonima, calificacion) 
                          VALUES ('$idRecibida', '$rut', '$titulo', '$resenia', '$fecha', '$anonimo', '$rating')";

                $resultado = mysqli_query($conexion, $query);

                echo"<script>
                    window.location.reload();  // Recarga la página actual
                </script>";
            }
        }
    }
}

?>
<div class="alert alert-warning" id="alerta_registro" role="alert" style="display: <?php echo $error_message ? 'block' : 'none'; ?>">
    <?php echo $error_message; ?>
</div>
<!-- Botón para abrir el modal de opinion -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#opinion_modal" <?php echo !$showButton ? 'hidden' : ''; ?>>
    Ingresar opinion
</button>


<div id="opinion_modal" class="modal fade" tabindex="-1" aria-labelledby="opinionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="opinionModalLabel">Ingrese su opinion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form name="reseaForm" method="POST" onsubmit="return validateRating()">
            <!-- Formulario de reseña -->
            <div class="rating row-2 d-flex justify-content-center" style="font-size: 2rem;">
                <i class="bi bi-star" data-value="1"></i>
                <i class="bi bi-star" data-value="2"></i>
                <i class="bi bi-star" data-value="3"></i>
                <i class="bi bi-star" data-value="4"></i>
                <i class="bi bi-star" data-value="5"></i>
                <input type="hidden" id="rating" name="rating" value="0" />

            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título Reseña</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingrese título de la reseña" required>
            </div>
            <div class="mb-3">
                <label for="resenia" class="form-label">Reseña</label>
                <textarea class="form-control" id="resenia" name="resenia" rows="3" placeholder="Ingrese su reseña" required></textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="anonimo" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Anónimo</label>
            </div>

             <!-- Botón de envío -->
            <button type="submit" name="enviar" id="enviar" class="btn btn-primary" >
                Enviar Opinión
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]'); // Selecciona el botón de envío
    let formSubmitted = false; // Flag para saber si el formulario ha sido enviado

    // Verificar si el formulario ya fue enviado (evitar envío accidental tras recarga)
    if (localStorage.getItem('formSubmitted')) {
        formSubmitted = true; // Si el formulario ya fue enviado, marcamos el flag
    }

    // Prevenir el envío al presionar "Enter" accidentalmente
    form.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevenir el envío accidental
        }
    });

    // Prevenir el envío del formulario si no fue enviado con el botón
    form.addEventListener('submit', function(event) {
            if (!formSubmitted) {
                event.preventDefault(); // Previene el envío si no fue hecho por el botón
                alert('Por favor, presione el botón de enviar.');
            }
        });

        // Cuando el botón de envío es presionado, marcamos que el formulario se va a enviar
        submitButton.addEventListener('click', function() {
            formSubmitted = true; // Marcamos que el formulario ha sido enviado
            localStorage.setItem('formSubmitted', 'true'); // Guardamos el estado en el almacenamiento local
            form.submit(); // Ahora enviamos el formulario
        });
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingInput = document.getElementById('rating'); // Obtener el input hidden
        const stars = document.querySelectorAll('.rating i'); // Obtener todas las estrellas

        // Función para actualizar la apariencia de las estrellas
        function updateStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('bi-star');
                    star.classList.add('bi-star-fill', 'text-warning');
                } else {
                    star.classList.remove('bi-star-fill', 'text-warning');
                    star.classList.add('bi-star');
                }
            });
        }

        // Función para gestionar el clic en las estrellas
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(star.getAttribute('data-value')); // Obtener el valor de la estrella seleccionada
                ratingInput.value = rating; // Guardar el valor en el input hidden
                updateStars(rating); // Actualizar la apariencia de las estrellas
            });

            // Evento de hover sobre las estrellas (previsualización de la calificación)
            star.addEventListener('mouseover', function() {
                const rating = parseInt(star.getAttribute('data-value'));
                updateStars(rating); // Previsualizar las estrellas resaltadas
            });

            // Evento de mouseout (restaurar la calificación seleccionada)
            star.addEventListener('mouseout', function() {
                updateStars(parseInt(ratingInput.value)); // Restaurar la calificación visual
            });
        });

        // Inicializar las estrellas con el valor actual de la calificación
        updateStars(parseInt(ratingInput.value)); // Si el valor es 0, no se llenarán las estrellas.
    });
</script>