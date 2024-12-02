<?php

if(isset($_POST['nombre'])&&isset($_POST['apellido'])&&isset($_POST['correo'])){
    $m_r=$_POST['nombre'];
    $d_r=$_POST['apellido'];
    $s_r=$_POST['correo'];

    $verificar = mysqli_query($conexion, "SELECT count(*)as cantidad FROM usuario_registrado WHERE correo = '$s_r'");
    $cantidad = mysqli_fetch_assoc($verificar)['cantidad'];
    if($cantidad==0){
        $editar_query = "UPDATE usuario_registrado SET nombre='$m_r', apellido='$d_r', correo='$s_r' WHERE rut= '$rut'";
        mysqli_query($conexion, $editar_query);
        echo "<a id='volver' href='perfil.php?accion=0'>Volver</a>";
       echo" <script>
                document.getElementById('volver').click();
            </script>";

    }else if($s_r!=$correo){
        $error_message='El correo ya se encuentra registrado';
    }

    
}
?>
    
    <p>Editando datos personales</p>
    <div class="alert alert-danger" id="alerta_registro" role="alert" style="display: <?php echo $error_message ? 'block' : 'none'; ?>">
        <?php echo $error_message; ?>
    </div>
    <form action="" method="post">
        <label for="">Nombre:</label>
        <br>
        <input type="text" name="nombre"  value=<?php echo $nombre?> required>
        <br>
        <label for="">Apellido:</label>
        <br>
        <input type="text" name="apellido"  value=<?php echo $apellido?> required>
        <br>
        <label for="">Correo:</label>
        <br>
        <input type="email" name="correo" value=<?php echo $correo?> required>
        <br>

        <input class="mt-2 btn btn-sm "type="submit" value="GUARDAR" style=' background: #ffc107;'>
        <hr>
        <a href="perfil.php?accion=0" class='btn btn-sm' style=' background: #2E2E2E; color:white;'>Cancelar</a>
    </form>



