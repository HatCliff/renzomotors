<?php
// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    include '../admin/navbaradmin.php';
} else {
    include '../components/navbaruser.php';
}
include('../config/conexion.php');
session_start();

if (isset($_GET['id'])) {
    $idRecibida = intval($_GET['id']);
} else {
    echo "<p>Error: ID del vehículo no proporcionado.</p>";
}

$error_message = '';

if (!isset($_SESSION['usuario'])) {
    $error_message = "Debe iniciar sesión para escribir una opinión.";
    echo "<script> enviar.style.display = 'none';</script>";
}else {
    $rut = $_SESSION['usuario']['rut'];
    $query_check = "SELECT * FROM opinion_vehiculo WHERE rut = '$rut' AND id_vehiculo = '$idRecibida'";
    $resultado_check = mysqli_query($conexion, $query_check);

    if (mysqli_num_rows($resultado_check) > 0) {
        $error_message = "Ya has registrado una reseña para este vehículo.";
        echo "<script> enviar.style.display = 'none';</script>";
    } else {
        $query_compra_check = "SELECT * FROM reserva_vehiculo join registro_reserva  WHERE rut_cliente = '$rut' AND id_vehiculo = '$idRecibida'";
        $resultado_compra_check = mysqli_query($conexion, $query_compra_check);

        if (mysqli_num_rows($resultado_compra_check) == 0) {
            echo "<script> enviar.style.display = 'none';</script>";
            $error_message = "Usted no ha realizado una compra de este vehículo.";
        } else {
            $row = mysqli_fetch_assoc($resultado_compra_check);
            if ($row['compra_concretada'] == 0) {
                echo "<script> enviar.style.display = 'none';</script>";
                $error_message = "Su compra todavía no está concretada.";
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error_message)) {
    $rating = $_POST['rating'] ?? 0;
    $titulo = $_POST['titulo'] ?? '';
    $resenia = $_POST['resenia'] ?? '';
    $anonimo = isset($_POST['anonimo']) ? 1 : 0;
    $fecha = date('Y-m-d');

    $query = "INSERT INTO opinion_vehiculo (id_vehiculo, rut, titulo_resenia, resenia, fecha_resenia, anonima, calificacion) 
              VALUES ('$idRecibida', '$rut', '$titulo', '$resenia', '$fecha', '$anonimo', '$rating')";
    
    $resultado = mysqli_query($conexion, $query);
    if (!$resultado) {
        die("Error al insertar reseña: " . mysqli_error($conexion));
    } else {
        echo "<script> window.location='vehiculo.php?id=$idRecibida';</script>";
    }
}
?>

<!-- HTML Form -->
<form name="reseña" method="POST" onsubmit="return validateRating()" >
    <div class="alert alert-danger" id="alerta_registro" role="alert" style="display: <?php echo $error_message ? 'block' : 'none'; ?>">
        <?php echo $error_message; ?>
    </div>
    
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

    <button type="submit" class="btn btn-primary" id="enviar">Enviar Reseña</button>
</form>

<script>
    const stars = document.querySelectorAll('.rating i');
    const ratingInput = document.getElementById('rating');

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

    function updateStars(rating) {
        stars.forEach((s, index) => {
            if (index < rating) {
                s.classList.remove('bi-star');
                s.classList.add('bi-star-fill', 'text-warning');
            } else {
                s.classList.remove('bi-star-fill', 'text-warning');
                s.classList.add('bi-star');
            }
        });
    }
</script>