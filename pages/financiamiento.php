<?php
include('../config/conexion.php');

$idRecibida = $_GET['id'];

//  obtener el precio asociadas al vehículo
$query_precio = "SELECT precio FROM vehiculos WHERE id_vehiculo = $idRecibida";
$result_precio = mysqli_query($conexion, $query_precio);

if ($result_precio && mysqli_num_rows($result_precio) > 0) {
    $row = mysqli_fetch_assoc($result_precio);
    $precio_vehiculo = $row['precio'];
}
?>
<!-- Contenido del modal -->
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
                // Consulta a la base de datos los tipo de financiamiento y sus datos
                $financiamiento = mysqli_query($conexion, "SELECT * FROM financiamiento");
                while ($row = mysqli_fetch_assoc($financiamiento)) {
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
    <!-- Informacion sobre los calculos ingresados -->
    <p id="usuario" cstyle="display: none;"></p>
    <p id="cae" cstyle="display: none;"></p>
    <p id="cuota"  style="display: none;"></p>
    <p id="credito"  style="display: none;"></p>
    <p id="tasa"  style="display: none;"></p> 
    <p id="informacion"  style="display: none;"></p> 

    <script>
        function realizarCalculo() {
            //Obtiene los datos ingresados
            const precio = <?php echo $precio_vehiculo; ?>;
            const degravamen = document.getElementById("degravamen").checked;
            const laboral= document.getElementById("laboral").checked;
            const pie= parseInt(document.getElementById("pie").value);
            const cantidad= parseInt(document.getElementById("cuotas").value);
            //Obtiene los datos sacado de financiamiento
            const selectTipoFinanciamiento = document.getElementById("tipo_financiamiento");
            const selectedOption = selectTipoFinanciamiento.options[selectTipoFinanciamiento.selectedIndex];
            const tasaInteres = parseFloat(selectedOption.getAttribute("data-tasa"));
            const requisito = selectedOption.getAttribute("data-req");
            const cantidad_cut = parseFloat(selectedOption.getAttribute("data-cut"));

            if(!cantidad || !pie){
                alert("Faltan datos por ingresar"); 
            }

            if(cantidad>=cantidad_cut)
            {
                alert("La cantidad maxima de este tipo de financiamiento es de: "+cantidad_cut);                
            }

            if(pie<=precio*0.20 && pie>=precio*0.80){
                alert("El pie no se encuentra entre el 20% y 80% del vehiculo");
            }

            if(cantidad<=cantidad_cut && pie>=precio*0.20 && pie<=precio*0.80)
            {
                const valorCredito = tasaInteres * precio + precio - pie;
                const valorCuota = valorCredito / cantidad;

                //transforma las cantidades en el formato de dinero CLP
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
                //Ingresa texto a las variables
                usuario.innerText = "Estimado cliente los resultados son los siguientes: ";
                credito.innerText = "Valor del crédito total: " + creditoFormateado;
                cuota.innerText = "Valor por cuota= " + cuotaFormateada;
                tasa.innerText = "Tasa de interés: " + tasaInteres;
                informacion.innerText = "Requisitos: " + requisito;

                //Muestra por pantalla los datos ingresados
                usuario.style.display = "block";
                cae.style.display = "block";
                credito.style.display = "block";
                cuota.style.display = "block";
                tasa.style.display = "block";
                informacion.style.display = "block";
            }           
        }
    </script>
