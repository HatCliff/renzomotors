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
                if ($resultado) {
                    echo "<script>document.getElementById('success').value = 'true';</script>";
                }
            }
        }
    }
}

?>
<div class="alert alert-danger" id="alerta_registro" role="alert" style="display: <?php echo $error_message ? 'block' : 'none'; ?>">
    <?php echo $error_message; ?>
</div>
<!-- Botón para abrir el modal de opinion -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#opinion_modal" <?php echo !$showButton ? 'disabled' : ''; ?>>
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
                <input type="hidden" name="rating" id="rating" value="0" />
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
            <button type="submit" name="enviar" id="enviar" class="btn btn-primary">
                Enviar Opinión
            </button>
        </form>
        <input type="hidden" id="success" value="false" />

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Verifica si el envío fue exitoso
                if (document.getElementById('success').value === 'true') {
                    location.reload(); // Recarga la página
                }
            });
        </script>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating i');
    const ratingInput = document.getElementById('rating');

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

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-value');
            ratingInput.value = rating;
            updateStars(rating);
        });

        star.addEventListener('mouseover', () => {
            const rating = star.getAttribute('data-value');
            updateStars(rating);
        });

        star.addEventListener('mouseout', () => {
            updateStars(ratingInput.value);
        });
    });
});
</script>