<?php
include('../config/conexion.php'); // Ajusta esta ruta si es necesario
$idRecibida = $_GET['id'];

//  obtener las fotos asociadas al vehículo para eliminarlas de la carpeta 
$query_precio = "SELECT precio FROM vehiculos WHERE id_vehiculo = $idRecibida";
$result_precio = mysqli_query($conexion, $query_precio);

if ($result_precio && mysqli_num_rows($result_precio) > 0) {
    $row = mysqli_fetch_assoc($result_precio);
    $precio_vehiculo = $row['precio'];
}


?>
    <div class="mt-3">
        <div class="row d-flex justify-content-center align-items-center text-center"> 
            <label for="exampleFormControlInput1" class="form-label" style="font-weight: bold; font-size: 30px;">Valor del vehiculo</label>
            <?php
            $precio_formateado = number_format($precio_vehiculo, 0, ',', '.'); 
            echo "<p>\$ " . $precio_formateado . " CLP</p>";
            ?>
        </div>
    </div>
    <br>
    <div>
        <label for="exampleFormControlInput1" class="form-label" style="font-weight: bold;">Pie</label>
        <input type="number" class="form-control" placeholder="Ingrese el pie (20% - 80% del precio total)" aria-label="Username" aria-describedby="addon-wrapping" id="pie" required>
    </div>
    <br>
    <div>
        <label for="exampleFormControlInput1" class="form-label" style="font-weight: bold;">Tipo de financiamiento</label>
        <select id="tipo_financiamiento" class="form-select" name="id_financiamiento" required>
            <?php
                // Consulta a la base de datos
                $fina = mysqli_query($conexion, "SELECT * FROM financiamiento");
                while ($row = mysqli_fetch_assoc($fina)) {
                    echo "<option value='{$row['id_financiamiento']}' data-tasa='{$row['tasa_interes']}' data-req='{$row['requisitos']}' data-cut='" . (int)substr($row['plazo_maximo'], 0, 2) . "'>{$row['nombre']}</option>";
                }
            ?>
        </select>
    </div>
    <br>
    <div>
        <label for="exampleFormControlInput1" class="form-label" style="font-weight: bold;">Cantidad de cuotas</label>
        <input id="cuotas" type="number" class="form-control" placeholder="Ingrese la cantidad de cuotas" aria-label="Username" aria-describedby="addon-wrapping" required>
    </div>
    <br>
    <div>
        <label for="exampleFormControlInput1" class="form-label" style="font-weight: bold;">Rut</label>
        <input type="number" id="rut_consulta" class="form-control" placeholder="Ingrese su rut sin guion ni puntos" aria-label="Ingrese su rut sin guion ni puntos" aria-describedby="addon-wrapping" required>
    </div>
    <br>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="degravamen">
        <label class="form-check-label" for="flexCheckDefault">Seguro de degravamen</label>
    </div>
    <br>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="laboral" checked>
        <label class="form-check-label" for="flexCheckChecked"> Seguro de proteccion laboral </label>
    </div>
    <br>
    <div class="d-grid gap-2 col-6 mx-auto">
        <button class="btn btn-dark" onclick="realizarCalculo()">CALCULAR</button>
    </div>

    <br>
    
    <p id="usuario" cstyle="display: none;"></p>
    <p id="cae" cstyle="display: none;"></p>
    <p id="cuota"  style="display: none;"></p>
    <p id="credito"  style="display: none;"></p>
    <p id="tasa"  style="display: none;"></p> 
    <p id="informacion"  style="display: none;"></p> 

    <script>
        function realizarCalculo() {
            const precio = <?php echo $precio_vehiculo; ?>;
            const degravamen = document.getElementById("degravamen").checked;
            const laboral= document.getElementById("laboral").checked;
            const pie= parseInt(document.getElementById("pie").value);
            const run = parseInt(document.getElementById("rut_consulta").value);
            
            const selectTipoFinanciamiento = document.getElementById("tipo_financiamiento");
            const selectedOption = selectTipoFinanciamiento.options[selectTipoFinanciamiento.selectedIndex];
            const tasaInteres = parseFloat(selectedOption.getAttribute("data-tasa"));
            const requisito = selectedOption.getAttribute("data-req");

            const cantidad= parseInt(document.getElementById("cuotas").value);
            const cantidad_cut = parseFloat(selectedOption.getAttribute("data-cut"));

            // $conuslta = run;
            // 
            //     $query_cliente= "SELECT nombre FROM usuario_registrado WHERE rut = $consulta";
            //     $result_cliente = mysqli_query($conexion, $query_cliente);
            //     if ($result_cliente && mysqli_num_rows($result_cliente) > 0) {
            //         $row = mysqli_fetch_assoc($result_cliente);
            //         $nombre = $row['nombre'];
            //     }
            // 

            // const nombre =

            if(!cantidad || !pie || !run){
                alert("Faltan datos por ingresar"); 
            }

            // if(!nombre)
            // {
                usuario.innerText = "Estimado cliente los resultados son los siguientes: ";
            // }

            if(cantidad>=cantidad_cut)
            {
                alert("La cantidad maxima de este tipo de financiamiento es de: "+cantidad_cut);                
            }

            if(run.toString().length > 9){
                alert("El rut no es valido" +run);
            }
            
            if(pie<=precio*0.20 && pie>=precio*0.80){
                alert("El pie no se encuentra entre el 20% y 80% del vehiculo");
            }

            if(cantidad<=cantidad_cut && pie>=precio*0.20 && pie<=precio*0.80 && run.toString().length<=9)
            {
                const valorCredito = tasaInteres * precio + precio - pie;
                const valorCuota = valorCredito / cantidad;

                const precioFormateado = precio.toLocaleString('es-CL', { style: 'currency', currency: 'CLP' });
                const creditoFormateado = valorCredito.toLocaleString('es-CL', { style: 'currency', currency: 'CLP' });
                const cuotaFormateada = valorCuota.toLocaleString('es-CL', { style: 'currency', currency: 'CLP' });

                if (degravamen && laboral){
                    cae.innerText = "CAE: 0.2080%";
                }else if(degravamen && !laboral){
                    cae.innerText = "CAE: 0.1940%";
                }else if(!degravamen && laboral){
                    cae.innerText = "CAE: 0.1913%";
                }else{
                    cae.innerText = "CAE: 0.1781%";
                }

                credito.innerText = "Valor del crédito total: " + creditoFormateado;
                cuota.innerText = "Valor por cuota= " + cuotaFormateada;
                tasa.innerText = "Tasa de interés: " + tasaInteres;
                informacion.innerText = "Requisitos: " + requisito;

                
                usuario.style.display = "block";
                cae.style.display = "block";
                credito.style.display = "block";
                cuota.style.display = "block";
                tasa.style.display = "block";
                informacion.style.display = "block";
            }           
        }
            // buscar si es usuario, si es se coloca el nombre de forma contrario solo cliente
</script>

