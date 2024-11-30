<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../../../config/conexion.php");
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['tipo_persona'] === 'administrador') {

        $rut_user = $_SESSION['rut'];
        $permisos = "SELECT p.* FROM permiso p
                                 JOIN rol_permiso rp ON rp.id_permiso = p.id_permiso
                                 JOIN rol r ON r.id_rol = rp.id_rol
                                 JOIN administrador a ON a.id_rol = r.id_rol
                                 WHERE a.rut_administrador = '$rut_user'";
        $result_permisos = $conexion->query($permisos);
        $lista_permisos = [];
        while ($permiso = $result_permisos->fetch_assoc()) {
            $lista_permisos[] = $permiso['nombre_permiso'];
            // echo "{$permiso['nombre_permiso']}";
        }

        if (in_array('Personal', $lista_permisos)) {
            include("../../navbaradmin.php");

            $nuevo = $_GET['rut'];
            $agregar = "UPDATE usuario_registrado SET tipo_persona = 'administrador' WHERE rut = '$nuevo'";
            $result_agregar = $conexion->query($agregar);

            if($result_agregar){
                echo "<script>alert('Administrador agregado con éxito'); window.location='nuevo_administrador.php';</script>";
            }

        } else {
            header('Location: dashboard.php');
        }
    } else {
        header('Location: ../../../index.php');
    }
} else {
    header('Location: ../../../pages/login.php');
}
?>