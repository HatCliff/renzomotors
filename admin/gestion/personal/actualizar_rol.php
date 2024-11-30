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
        }

        if (in_array('Personal', $lista_permisos)) {
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $rut = $_POST['rut'];
                $rol = $_POST['id_rol'];

                $dar_rol ="UPDATE administrador SET id_rol = '$rol' WHERE rut_administrador = '$rut'";
                $result_dar = $conexion->query($dar_rol);
                if($result_dar){
                    echo "<script>alert('Rol asignado con éxito'); window.location='../personal.php';</script>";
                }
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