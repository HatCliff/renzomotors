<?php
include '../conexion.php';
include '../navbar.php';
$idRecibida = $_GET['id'];

//  obtener las fotos asociadas al vehículo para eliminarlas de la carpeta 
$query_precio = "SELECT precio FROM vehiculos WHERE id_vehiculo = $idRecibida";
$result_precio = mysqli_query($conexion, $query_precio);

if ($result_precio && mysqli_num_rows($result_precio) > 0) {
    $row = mysqli_fetch_assoc($result_precio);
    $precio_vehiculo = $row['precio'];
}

?>


    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Valor del Vehiculo</span>
        <?php echo "<p>{$precio_vehiculo}</p>";?>
    </div>
    <br>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Pie</span>
        <input type="number" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" id="pie" required>
    </div>
    <br>


    <div class="input-group flex-nowrap">
        <span for="id_financiamiento" class="input-group-text" id="addon-wrapping">Tipo de financiamiento</span>
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

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Cantidad de cuotas</span>
        <input id="cuotas" type="number" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" required>
    </div>
    <br>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Rut</span>
        <input type="text" id="rut_consulta" class="form-control" placeholder="Ingrese su rut sin guion ni puntos" aria-label="Ingrese su rut sin guion ni puntos" aria-describedby="addon-wrapping">
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

    <div class="input-group flex-nowrap">
        <button class="btn btn-primary" onclick="realizarCalculo()">Calcular</button>
    </div>

    <br>
    <p id="cae" class="mt-1" style="display: none;"></p>
    <p id="cuota" class="mt-1" style="display: none;"></p>
    <p id="credito" class="mt-1" style="display: none;"></p>
    <p id="tasa" class="mt-1" style="display: none;"></p> 
    <p id="informacion" class="mt-1" style="display: none;"></p> 

    <script>
        function realizarCalculo() {
            const precio = <?php echo $precio_vehiculo; ?>;
            const degravamen = document.getElementById("degravamen").checked;
            const laboral= document.getElementById("laboral").checked;
            const cantidad= parseInt(document.getElementById("cuotas").value,2);
            const pie= parseInt(document.getElementById("pie").value);
            
            const selectTipoFinanciamiento = document.getElementById("tipo_financiamiento");
            const selectedOption = selectTipoFinanciamiento.options[selectTipoFinanciamiento.selectedIndex];
            const tasaInteres = parseFloat(selectedOption.getAttribute("data-tasa"));
            const requisito = selectedOption.getAttribute("data-req");
            const cantidad_cut = parseFloat(selectedOption.getAttribute("data-cut"));

            if(cantidad>=cantidad_cut)
            {
                alert("La cantidad maxima de este tipo de financiamiento es de: "+cantidad_cut);                
            }
            
            if(pie<=precio*0.20 && pie>=precio*0.80){
                alert("El pie no se encuentra entre el 20% y 80% del vehiculo");
            }

            if(cantidad<=cantidad_cut && pie>=precio*0.20 && pie<=precio*0.80)
            {
                if (degravamen && laboral){
                    cae.innerText = "CAE es: 0.2080%";
                }else if(degravamen && !laboral){
                    cae.innerText = "CAE es: 0.1940%";
                }else if(!degravamen && laboral){
                    cae.innerText = "CAE es: 0.1913%";
                }else{
                    cae.innerText = "CAE es: 0.1781%";
                }

                credito.innerText = "El Valor del credito es de "+ (tasaInteres*precio + precio-pie);
                cuota.innerText = "Valor por cuota= "+((tasaInteres*precio + precio-pie)/cantidad);
                tasa.innerText = "Tasa de interés: " + tasaInteres;
                informacion.innerText = "Requesitos: " + requisito;
                    
                cae.style.display = "block";
                credito.style.display = "block";
                cuota.style.display = "block";
                tasa.style.display = "block";
                informacion.style.display = "block";
            }           
        }
            // buscar si es usuario, si es se coloca el nombre de forma contrario solo cliente
</script>

