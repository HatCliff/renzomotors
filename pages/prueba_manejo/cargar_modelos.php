<?php
// Conexión a la base de datos
include("../../config/conexion.php");

// Verificar que se haya enviado el ID de la marca
if (isset($_POST['marca'])) {
    $marca_id = $_POST['marca'];

    // Consulta para obtener los modelos de la marca seleccionada
    $modelos = mysqli_query($conexion, "SELECT id_vehiculo, nombre_modelo FROM vehiculo WHERE id_marca = '$marca_id'");

    // Generar las opciones de los modelos
    while ($modelo = mysqli_fetch_assoc($modelos)) {
        echo "<option value='{$modelo['id_vehiculo']}'>{$modelo['nombre_modelo']}</option>";
    }
}
?>
