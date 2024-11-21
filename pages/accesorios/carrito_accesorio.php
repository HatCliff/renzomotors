<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../config/conexion.php');

if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../../components/navbaruser.php';
}

$rut_user = $_SESSION['rut'];

$carrito = "SELECT ca.*, a.nombre_accesorio, a.precio_accesorio, fa.foto_accesorio
            FROM carrito_accesorio ca
            JOIN carrito_usuario cu ON ca.id_carrito = cu.id_carrito
            JOIN accesorio a ON ca.sku_accesorio  = a.sku_accesorio
            JOIN fotos_accesorio fa ON a.sku_accesorio = fa.sku_accesorio
            WHERE rut_usuario = '$rut_user'
            GROUP BY ca.sku_accesorio";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mi Carrito</title>
    <!-- Dar color al fondo de la pagina -->
    <style>
        body {
            background: #E6E6E6;
        }
    </style>
</head>

<body class="pt-5">

    <div class="container mt-5">
        <div class="row">
            <div class="col-8">
                <?php
                $result_carro = mysqli_query($conexion, $carrito);
                while ($item = mysqli_fetch_assoc($result_carro)) {
                    $precio_formateado = number_format($item['precio_accesorio'], 0, ',', '.');
                    echo "
                        <div class='col-12 mt-3 rounded px-3 py-3 d-flex' style='background: #fffcf4;' data-sku='{$item['sku_accesorio']}'>
                            <img src='../../admin/mantenedores/accesorios/{$item['foto_accesorio']}' class='img-thumbnail' alt='' style='min-width: 100px; max-height: 100px'>
                            <div class='mx-3 w-100'>
                                <div class='d-flex justify-content-between align-items-center w-100'>
                                    <strong>{$item['nombre_accesorio']}</strong>
                                    <a href='funciones_carrito/eliminar_item.php?sku={$item['sku_accesorio']}' class='btn btn-danger d-flex align-items-center btn-remove' style='max-height: 20px;' title='Quitar' >-</a>
                                </div>
                                <p class='text-success fw-bold'>$ {$precio_formateado}</p>
                                <div class='d-flex justify-content-between align-items-center w-100'>
                                    <div class='d-flex align-items-center'>
                                        <button class='btn btn-secondary btn-sm btn-decrease'>-</button>
                                        <span class='mx-2 cantidad bg-light'>{$item['cantidad_accesorio']}</span>
                                        <button class='btn btn-secondary btn-sm btn-increase'>+</button>
                                    </div>
                                    <div class='text-secondary'>SKU: {$item['sku_accesorio']}</div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                ?>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('.btn-increase').forEach(button => {
                            button.addEventListener('click', function () {
                                const parent = this.closest('[data-sku]');
                                const sku = parent.dataset.sku;
                                const cantidadElement = parent.querySelector('.cantidad');
                                let cantidad = parseInt(cantidadElement.textContent, 10);
                                if (cantidad < 5) {
                                    cantidad++;
                                    cantidadElement.textContent = cantidad;
                                }

                                // Actualizar en servidor
                                actualizarCantidad(sku, cantidad);
                            });
                        });

                        document.querySelectorAll('.btn-decrease').forEach(button => {
                            button.addEventListener('click', function () {
                                const parent = this.closest('[data-sku]');
                                const sku = parent.dataset.sku;
                                const cantidadElement = parent.querySelector('.cantidad');
                                let cantidad = parseInt(cantidadElement.textContent, 10);
                                if (cantidad > 1) {
                                    cantidad--;
                                    cantidadElement.textContent = cantidad;

                                    // Actualizar en servidor
                                    actualizarCantidad(sku, cantidad);
                                }
                            });
                        });

                        function actualizarCantidad(sku, cantidad) {
                            fetch('funciones_carrito/actualizar_carrito.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `sku=${sku}&cantidad_accesorio=${cantidad}`
                            })

                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        console.log('Cantidad actualizada');
                                        // Actualiza el precio mostrado en la interfaz
                                        document.getElementById("precio_total").innerText = `$ ${data.nuevo_valor}`;
                                    } else {
                                        console.error('Error al actualizar cantidad');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }


                    });
                </script>


            </div>
            <div class="col-4 text-white rounded mt-3" style="background: #4a7338; height: 260px">
                <p class="text-center fs-3 mt-3">Resumen</p>
                <div class="mx-3 d-flex justify-content-between flex-row">
                    <p>Valor carrito:</p>
                    <p id="precio_total">
                        <?php
                        $query = "SELECT valor_carrito FROM carrito_usuario WHERE rut_usuario = '$rut_user'";
                        $result_q = mysqli_query($conexion, $query);
                        $row = mysqli_fetch_assoc($result_q);
                        $valor_carrito = number_format($row['valor_carrito'], 0, ',', '.');
                        echo "$ {$valor_carrito}";
                        ?>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>

</script>