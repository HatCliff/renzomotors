<?php
include '../conexion.php';

$sku = $_GET['sku'];
//eliminar las fotos del accesorio 
$query_fotos = "SELECT foto_accesorio FROM fotos_accesorio WHERE sku_accesorio = '$sku'";
$result_fotos = mysqli_query($conexion, $query_fotos);
if ($result_fotos) {
    while ($foto = mysqli_fetch_assoc($result_fotos)) {
        $ruta_foto = $foto['foto_accesorio'];
        if (file_exists($ruta_foto)) {
            unlink($ruta_foto); // Elimina la foto de la carpeta
        }
    }
}

// eliminar relaciones con tipos de accesorios
$query_elimiar_foto = "DELETE FROM fotos_accesorio WHERE sku_accesorio='$sku'";
mysqli_query($conexion, $query_elimiar_foto);

// eliminar relaciones con tipos de accesorios
$query_tipo = "DELETE FROM pertenece_tipo WHERE sku_accesorio='$sku'";
mysqli_query($conexion, $query_tipo);

// eliminar elemento
$query = "DELETE FROM accesorio WHERE sku_accesorio='$sku'";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo "<script>alert('Accesorio eliminado con éxito'); window.location='mantenedor_accesorios.php';</script>";
} else {
    echo "Error al eliminar el accesorio: " . mysqli_error($conexion);
}
?>
