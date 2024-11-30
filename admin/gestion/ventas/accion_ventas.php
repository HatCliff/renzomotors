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

        if (in_array('Ventas', $lista_permisos)) {
            include("../../navbaradmin.php");

            $accion = $_GET['Accion'];
            $id = $_GET['id'];

            if($accion === 'A'){
                $venta = "UPDATE registro_reserva SET compra_concretada = 1 WHERE id_registro_reserva = $id";
            }elseif($accion === 'B'){
                $venta = "UPDATE registro_reserva SET compra_concretada = 0 WHERE id_registro_reserva = $id";
                $reincorporar = "UPDATE vehiculo SET cantidad_vehiculo = (cantidad_vehiculo + 1) 
                                 WHERE id_vehiculo = (SELECT rv.id_vehiculo FROM reserva_vehiculo rv 
                                                      JOIN registro_reserva rr ON rr.num_reserva_vehiculo = rv.num_reserva_vehiculo
                                                      WHERE id_registro_reserva = $id)";
                $result_reincorporar = $conexion->query($reincorporar);
            }
            
            $result_venta = $conexion->query($venta);
            if($result_venta){
                echo "<script>alert('Cambio Registrado'); window.location='confirmacion_ventas.php';</script>";
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