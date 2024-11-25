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

$carrito = "SELECT ca.*, a.nombre_accesorio, a.precio_accesorio, a.stock_accesorio, fa.foto_accesorio
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Mi Carrito</title>
    <!-- Dar color al fondo de la pagina -->
    <style>
        body {
            background: #E6E6E6;
        }

        .toast-fade-out {
            transition: opacity 1s ease-in-out;
            opacity: 0;
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
                                    <button class='btn btn-danger d-flex align-items-center btn-remove' 
                                          data-sku={$item['sku_accesorio']}
                                          style='max-height: 20px;' 
                                          title='Quitar'>-</button>
                                </div>
                                <p class='text-success fw-bold'>$ {$precio_formateado}</p>
                                <div class='d-flex justify-content-between align-items-center w-100'>
                                    <div class='d-flex align-items-center'>
                                        <button class='btn btn-secondary btn-sm btn-decrease'>-</button>
                                        <span class='mx-2 cantidad bg-light'>{$item['cantidad_accesorio']}</span>
                                        <button class='btn btn-secondary btn-sm btn-increase'>+</button>";
                    if ($item['stock_accesorio'] == 0) {
                        echo "<span class='mx-2 text-danger d-flex align-items-center'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-exclamation-triangle' viewBox='0 0 16 16'>
                                              <path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z'/>
                                              <path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z'/>
                                            </svg>
                                            <div class='px-1'>
                                                Producto agotado
                                            </div>
                                            </span>";
                    } elseif ($item['stock_accesorio'] <= 10) {
                        echo "<span class='mx-2 text-danger d-flex align-items-center'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-exclamation-triangle' viewBox='0 0 16 16'>
                          <path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z'/>
                          <path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z'/>
                        </svg>
                        <div class='px-1'>
                            {$item['stock_accesorio']} un. restatntes
                        </div>
                        </span>";
                    }

                    echo "</div>

                                    <div class='text-secondary'>SKU: {$item['sku_accesorio']}</div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                ?>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        $(document).on('click', '.btn-increase', function () {
                            const parent = $(this).closest('[data-sku]');
                            const sku = parent.data('sku');
                            const cantidadElement = parent.find('.cantidad');
                            let cantidad = parseInt(cantidadElement.text(), 10);

                            if (cantidad < 5) {
                                cantidad++;
                                cantidadElement.text(cantidad);

                                actualizarCantidad(sku, cantidad);
                            }
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

                    $(document).on('click', '.btn-remove', function (e) {
                        e.preventDefault();
                        const sku = $(this).data('sku');
                        const parentElement = $(this).closest('[data-sku]');

                        $.ajax({
                            url: 'funciones_carrito/eliminar_item.php',
                            method: 'POST',
                            data: { sku: sku },
                            success: function (response) {
                                if (response.success) {
                                    // Actualizar el precio total sin recargar la página
                                    $('#precio_total').text(`$ ${response.valor_carrito}`);
                                    // Eliminar el artículo de la interfaz
                                    parentElement.remove();
                                    location.reload();
                                } else {
                                    console.error(response.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Error al eliminar el accesorio:', error);
                            }
                        });
                    });

                    document.addEventListener('DOMContentLoaded', function () {
                        const form = document.querySelector('form');
                        const submitButton = form.querySelector('button[type="submit"]');
                        const toastContainer = document.createElement('div');
                        toastContainer.className = 'toast-container position-fixed end-0 p-3';
                        toastContainer.style.top = '70px';
                        document.body.appendChild(toastContainer);

                        form.addEventListener('submit', function (e) {
                            e.preventDefault(); // Prevenimos el envío tradicional del formulario

                            // Verificamos stock antes de proceder
                            fetch('./funciones_carrito/verificar_stock.php')
                                .then(response => response.json())
                                .then(data => {
                                    if (!data.success && data.errors) {
                                        data.errors.forEach(error => {
                                            const toast = document.createElement('div');
                                            toast.className = 'toast align-items-center text-bg-danger border-0 show';
                                            toast.setAttribute('role', 'alert');
                                            toast.setAttribute('aria-live', 'assertive');
                                            toast.setAttribute('aria-atomic', 'true');
                                            toast.innerHTML = `
                                            <div class="d-flex">
                                                <div class="toast-body">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                                                         class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
                                                        <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                                                        <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                                                    </svg>
                                                    ${error.mensaje}
                                                </div>
                                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>`;
                                            toastContainer.appendChild(toast);

                                            setTimeout(() => {
                                                toast.classList.add('toast-fade-out');
                                                setTimeout(() => {
                                                    toast.remove();
                                                }, 1000);
                                            }, 3500);
                                        });
                                    }
                                    else {
                                        document.querySelector('#form-sucursal').addEventListener('submit', function (e) {
                                            e.preventDefault(); // Prevenir el envío tradicional del formulario

                                            const sucursalSeleccionada = this.querySelector('[name="sucursal_compra"]').value; // Obtener valor de la sucursal

                                            if (sucursalSeleccionada) {
                                                // Redirigir a la URL con el parámetro seleccionado
                                                window.location.href = `../../auth/transaction_accesorio.php?suc=${sucursalSeleccionada}`;
                                            } else {
                                                alert('Por favor, selecciona una sucursal.');
                                            }
                                        });

                                    }

                                })
                        });
                    });


                </script>


            </div>
            <div class="col-4 text-white rounded mt-3"
                style="background: linear-gradient(to bottom, #4a7338, #5e8f56); height: 260px">
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
                <div class="mx-3">
                    <form id="form-sucursal">
                        <label for="sucursal_compra_a" class="form-label">Sucursal:</label>
                        <div class="mb-3 d-flex">
                            <?php
                            $sucursales = "SELECT * FROM sucursal ORDER BY zona_sucursal";
                            $result_suc = mysqli_query($conexion, $sucursales);
                            $current_zone = '';
                            echo "<select class='btn form-select js-example-basic-single' name='sucursal_compra' required>";
                            while ($sucursal = mysqli_fetch_assoc($result_suc)) {
                                if ($current_zone !== $sucursal['zona_sucursal']) {
                                    $current_zone = $sucursal['zona_sucursal'];
                                    echo "<optgroup label='{$current_zone}'>";
                                }
                                echo "<option value='{$sucursal['id_sucursal']}'>{$sucursal['nombre_sucursal']}</option>";
                            }
                            echo "</optgroup></select>";
                            ?>
                            <a href="../sucursales.php" class="text-light px-1 d-flex align-items-center"
                                style="text-decoration: none" title="Nuestras Sucursales">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-question-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94" />
                                </svg>
                            </a>
                        </div>
                        <button type="submit" class="btn btn-light rounded-pill w-100">Enviar</button>
                    </form>

                    <script>
                        $(document).ready(function () {
                            $('.js-example-basic-single').select2();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>

</script>