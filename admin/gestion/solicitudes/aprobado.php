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

        if (in_array('Solicitudes', $lista_permisos)) {
            include("../../navbaradmin.php");

            $patente = $_GET['patente'];
            $aprobar = "UPDATE vehiculo_ofertado SET aprobacion = 1, rut_administrador = '$rut_user' WHERE patente = '$patente'";
            $result_aprobar = $conexion->query($aprobar);

            if($result_aprobar){
                echo "<script>alert('Solicitud Aprobada'); window.location='solicitudes_autos.php';</script>";
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