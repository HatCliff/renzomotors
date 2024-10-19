<?php
include('../config/conexion.php');

$idRecibida = $_GET['id'];
$rut='';
$error_message = '';

// Verificar si ya existe una reseña para este rut y vehículo
$query_check = "SELECT * FROM opinion_vehiculo WHERE rut = '$rut' AND id_vehiculo = '$idRecibida'";
$resultado_check = mysqli_query($conexion, $query_check);

if (mysqli_num_rows($resultado_check) > 0) {
    // Si ya existe una reseña, mostrar un mensaje de error
    $error_message = "Ya has registrado una reseña para este vehículo.";
}

$query_compra_check = "SELECT * FROM registro_reserva WHERE rut = '$rut' AND id_vehiculo = '$idRecibida' ";
$resultado_compra_check  = mysqli_query($conexion, $query_compra_check);
$row = mysqli_fetch_assoc($resultado_compra_check);

if (mysqli_num_rows($resultado_compra_check ) == 0) {
    // Si ya existe una reseña, mostrar un mensaje de error
    $error_message = "usted no a realizado una compra de este vehículo";

}elseif($row['compra_concretada']==0){
    $error_message = "su compra todavia no esta concretada";  
}

if($rut == '')
{
    $error_message = "Debe inicar sesion para escribir una opnión";  
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'] ?? 0;
    $titulo = $_POST['titulo'] ?? '';
    $resenia = $_POST['resenia'] ?? '';
    $anonimo = isset($_POST['anonimo']) ? 1 : 0;
    $fecha = date('Y-m-d');

    // Si no existe, insertar la nueva reseña
    $query = "INSERT INTO opinion_vehiculo (id_vehiculo, rut, titulo_resenia, resenia, fecha_resenia, anonima, calificacion) 
                VALUES ('$idRecibida', '$rut', '$titulo', '$resenia', '$fecha', '$anonimo', '$rating')";

    $resultado = mysqli_query($conexion, $query);
    echo "<script> window.location='vehiculo.php?id=$idRecibida';</script>";
}
?>      
    <form name="reseña" method="POST" onsubmit="return validateRating()">
        <div class="alert alert-danger" id="alerta_registro" role="alert" style="display: <?php echo $error_message ? 'block' : 'none'; ?>">
            <?php echo $error_message; ?>
        </div>

        <div class="rating row-2 d-flex justify-content-center" style="font-size: 2rem;" >
            <i class="bi bi-star" data-value="1"></i>
            <i class="bi bi-star" data-value="2"></i>
            <i class="bi bi-star" data-value="3"></i>
            <i class="bi bi-star" data-value="4"></i>
            <i class="bi bi-star" data-value="5"></i>
            <input type="hidden" name="rating" id="rating" value="<?php echo $current_rating; ?>" />
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

        <button type="submit" class="btn btn-primary <?php echo !empty($error_message) ? 'd-none' : ''; ?>"  name="boton">Enviar Reseña</button>

    </form>

<script>
    const stars = document.querySelectorAll('.rating i');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-value');
            ratingInput.value = rating;

            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill', 'text-warning');
                } else {
                    s.classList.remove('bi-star-fill', 'text-warning');
                    s.classList.add('bi-star');
                }
            });
            console.log('Valor seleccionado:', rating);
        });
    });
</script>