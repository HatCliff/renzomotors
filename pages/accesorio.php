<?php
// Conexión a la base de datos
include('../config/conexion.php'); 

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtener el ID del accesorio

    // Realizar la consulta para obtener los detalles del accesorio
    $query = "SELECT * FROM accesorio WHERE sku_accesorio = '$id'";
    $resultado = mysqli_query($conexion, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        // Mostrar los datos del accesorio
        echo "<h3>" . $fila['nombre_accesorio'] . "</h3>";
        echo "<p><strong>Precio:</strong> $" . number_format($fila['precio_accesorio'], 0, ',', '.') . " CLP</p>";
        echo "<p><strong>Descripción:</strong> " . $fila['descripcion_accesorio'] . "</p>";
        // Aquí puedes agregar más detalles, como imágenes, etc.
    } else {
        echo "<p>Accesorio no encontrado.</p>";
    }
}
?>
