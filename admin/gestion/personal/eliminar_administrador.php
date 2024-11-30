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

            $eliminar = $_GET['rut'];
            $eliminar_rol = "UPDATE administrador SET id_rol = NULL WHERE rut_administrador = '$eliminar'";
            $result_eliminar_rol = $conexion->query($eliminar_rol);
            
            $expulsar = "UPDATE usuario_registrado SET tipo_persona = 'usuario' WHERE rut = '$eliminar'";
            $result_expulsar = $conexion->query($expulsar);
            if($result_expulsar){
                echo "<script>alert('Administrador eliminado con éxito'); window.location='../personal.php';</script>";
            }

        } else {
            header('Location: ../dashboard.php');
        }
    } else {
        header('Location: ../../../index.php');
    }
} else {
    header('Location: ../../../pages/login.php');
}
?>