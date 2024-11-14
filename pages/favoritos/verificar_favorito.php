<?php
session_start();
include("../../config/conexion.php");
$id_vehiculo = $_GET['id_vehiculo'];

$isFavorito = false;
if (isset($_SESSION['rut'])) {
    $id_usuario = $_SESSION['rut'];
    $favorito_query = "SELECT * FROM favoritos WHERE id_usuario = '$id_usuario' AND id_vehiculo = $id_vehiculo";
    $favorito_result = mysqli_query($conexion, $favorito_query);
    $isFavorito = mysqli_num_rows($favorito_result) > 0;
}
// Icono de favorito en la esquina superior derecha
echo "<div class='favorite-icon' id='icono-favorito-$id_vehiculo'>";
echo "<i class='fas fa-star " . ($isFavorito ? 'favorite-checked' : 'favorite-unchecked') . "' onclick='toggleFavorito(event, $id_vehiculo); actualizar_fav($id_vehiculo);' style='font-size: 24px; color: " . ($isFavorito ? '#FFD700' : '#CCCCCC') . "; cursor: pointer;'></i>";
echo "</div>";
?>
