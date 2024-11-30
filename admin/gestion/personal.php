<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../../config/conexion.php");
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
            include("../navbaradmin.php");
        } else {
            header('Location: dashboard.php');
        }
    } else {
        header('Location: ../../index.php');
    }
} else {
    header('Location: ../../pages/login.php');
}

$administradores = "SELECT a.*, ur.nombre , ur.apellido, r.nombre_rol FROM usuario_registrado ur
                    JOIN administrador a ON ur.rut = a.rut_administrador
                    LEFT JOIN rol r ON a.id_rol = r.id_rol";
$result_admin = $conexion->query($administradores);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="sweetalert2.all.min.js"></script>
    <title>Personal</title>
</head>

<body class="pt-5 mt-3">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Gestión de Personal</h1>
                <a href='personal/nuevo_administrador.php' class='btn btn-success' title='Agregar Administrador'>Agregar</a>
                <table id="miTabla" class="display table table-striped table-bordered" style="width:100%">
                    <thead class="table table-dark">
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>ROL</th>
                            <th style="max-width: 250px; width: 150px; white-space: nowrap;">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($admin = mysqli_fetch_assoc($result_admin)) {
                            echo "
                        <tr>
                            <td>{$admin['rut_administrador']}</td>
                            <td>{$admin['nombre']} {$admin['apellido']}</td>
                            <td>{$admin['nombre_rol']}</td>
                            <td>
                            <a href='' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalCambiarRol{$admin['rut_administrador']}' title='Cambiar Rol'>Cambiar</a>
                            <a href='personal/eliminar_administrador.php?rut={$admin['rut_administrador']}' class='btn btn-danger' title='Eliminar Administrador'>Eliminar</a>
                            </td>
                        </tr>
                        ";

                            // Modal para Cambiar Rol
                            echo "
                            <div class='modal fade' id='modalCambiarRol{$admin['rut_administrador']}' tabindex='-1' aria-labelledby='modalCambiarRolLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='modalCambiarRolLabel'>Cambiar Rol de Administrador</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <p>Recuerda que este cambio puede afectar su acceso al sistema de <strong>{$admin['nombre']} {$admin['apellido']}</strong>.</p>
                                            <form action='personal/actualizar_rol.php' method='POST'>
                                                <input type='hidden' name='rut' value='{$admin['rut_administrador']}'>
                                                <div class='mb-3'>
                                                    <label for='InputRol' class='form-label'>Nuevo Rol</label>
                                                    <select class='form-select' name='id_rol' required>
                                                        ";
                            $roles = mysqli_query($conexion, "SELECT * FROM rol");
                            while ($rol = mysqli_fetch_assoc($roles)) {
                                $selected = ($rol['id_rol'] == $admin['id_rol']) ? 'selected' : '';
                                echo "<option value='{$rol['id_rol']}' $selected>{$rol['nombre_rol']}</option>";
                            }
                            echo "
                                                    </select>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='submit' class='btn btn-primary'>Confirmar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function () {
        $('#miTabla').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sPrevious": "Anterior",
                    "sNext": "Siguiente",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>
