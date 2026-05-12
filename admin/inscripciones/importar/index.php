<?php
include ('../../../app/config.php');
include ('../../../admin/layout/parte1.php');


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Inscripciones:  <?=$ano_actual;?></h1>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-outline card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Datos de los estudiantes</h3>
                    <div class="card-tools">
                          <a href="PLANTILLA_IMPORTAR_ESTUDIANTES.xlsx" class="btn btn-success"><i class="bi bi-cloud-download-fill"></i>Descargar plantilla</a>
                    </div>
                  </div>
                  <div class="card-body">
                        <input type="file" id="my_file_input" class="form-control" />
                        <div id="imgImport">
                          <b
                          <center>

                          </center>
                        </div>
                        <br>
                        <div class="table table-responsive">
                          <table id='my_file_output' border=""
                                class="table table-bordered table-condensed table-striped"></table>
                        </div>
                        <button id="btn-lectura" class="btn btn-info">Registrar estudiantes</button>
                        <a href="" class="btn btn-default">Cancelar</a>
                        <p id="respuesta">

                        </p>
                        <p id="contador">

                        </p>
                  </div>
                </div>
              </div>
              

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
 <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('my_file_input').addEventListener('change', function (e) {
        console.log("PUNTO 1: Evento 'change' detectado.");

        let archivo = e.target.files[0];
        if (!archivo) {
            console.error("PUNTO 1a: No se encontró ningún archivo.");
            return;
        }

        let lector = new FileReader();

        lector.onload = function (e) {
            console.log("PUNTO 3: FileReader completó la carga.");
            let data = e.target.result;
            let workbook = null;
            
            try {
                // Conversión del ArrayBuffer a String Binario para XLSX
                let bytes = new Uint8Array(data);
                let binaryString = bytes.reduce((acc, current) => acc + String.fromCharCode(current), "");
                workbook = XLSX.read(binaryString, { type: 'binary' });

            } catch (error) {
                console.error("PUNTO ERROR: Error al leer el archivo con XLSX.read:", error);
                alert("Error al procesar el contenido del archivo.");
                return; 
            }

            if (!workbook.SheetNames || workbook.SheetNames.length === 0) {
                console.error("PUNTO ERROR: El archivo Excel no contiene hojas visibles.");
                alert("El archivo no tiene hojas de datos.");
                return;
            }
            
            let firstSheet = workbook.SheetNames[0];

            let excelRows = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheet], {
                header: 1,      
                defval: ""      
            });

            // =========================================================
            // *** NUEVA LÓGICA: FILTRAR FILAS COMPLETAMENTE VACÍAS ***
            // =========================================================
            let filteredRows = excelRows.filter(row => {
                // Mantiene la fila si al menos una celda no está vacía ("")
                return row.some(cell => cell !== "");
            });
            // =========================================================
            
            if (filteredRows.length > 0) {
                 console.log(`PUNTO 6: Se leyeron y filtraron ${filteredRows.length} filas (Encabezado + Datos).`);
            } else {
                 console.log("PUNTO 6: No se encontraron datos válidos.");
            }

            // Limpiar tabla
            document.getElementById('my_file_output').innerHTML = "";

            // Insertar datos en tabla (usamos filteredRows)
            filteredRows.forEach(function(row){
                let htmlRow = "<tr>";
                row.forEach(function(col){
                    htmlRow += `<td>${col}</td>`;
                });
                htmlRow += "</tr>";
                document.getElementById('my_file_output').innerHTML += htmlRow;
            });

            document.getElementById("imgImport").style.display = "none";
        };

        lector.readAsArrayBuffer(archivo);
    });
});
</script>

### 2. Script de Envío de Datos a PHP (`$('#btn-lectura').click()`)

Este script es el que se encarga de **saltar la primera fila (encabezado)** y **comprobar que el CI y el rol_id no estén vacíos** antes de hacer la llamada AJAX.

```javascript
<script>
  // Función de utilidad para convertir el número de Excel a formato de fecha YYYY-MM-DD
function excelDateToISO(excelDate) {
    // Si la celda está vacía o no es un número, devolver vacío
    if (isNaN(excelDate) || excelDate === "") {
        return "";
    }
    
    // Excel usa el 1 de enero de 1900 como día 1.
    // Restamos 1 para compensar el día base
    let date = new Date(Date.UTC(0, 0, excelDate - 1));
    
    // Formatear a YYYY-MM-DD
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0'); // M + 1 porque M empieza en 0
    let day = String(date.getDate()).padStart(2, '0');
    
    return `${year}-${month}-${day}`;
}
  $('#btn-lectura').click(function(){
    valores=new Array();
    var contador = 0;
    $('#my_file_output tr').each(function(index){ // Usamos 'index' para el índice de la fila
        
        // =========================================================
        // *** 1. SALTAR EL ENCABEZADO ***
        // =========================================================
        if (index === 0) {
            console.log("Saltando fila de encabezado.");
            return true; // Continúa al siguiente elemento (salta el bucle)
        }
        // =========================================================

        // Obtener los datos de la fila actual
        var d1 = $(this).find('td').eq(0).html();
        var d2 = $(this).find('td').eq(1).html();
        var d3 = $(this).find('td').eq(2).html();
        var d4 = $(this).find('td').eq(3).html(); // CI
        var d5 = $(this).find('td').eq(4).html();
        var d6 = $(this).find('td').eq(5).html();
        var d7 = $(this).find('td').eq(6).html();
        var d8 = $(this).find('td').eq(7).html();
        var d9 = $(this).find('td').eq(8).html();
        var d10 = $(this).find('td').eq(9).html();
        var d11 = $(this).find('td').eq(10).html();
        var d12 = $(this).find('td').eq(11).html();
        var d13 = $(this).find('td').eq(12).html();
        var d14 = $(this).find('td').eq(13).html();
        var d15 = $(this).find('td').eq(14).html();
        var d16 = $(this).find('td').eq(15).html();
        var d17 = $(this).find('td').eq(16).html();
        var d18 = $(this).find('td').eq(17).html();

        // =========================================================
        // *** 2. SALTAR FILAS CON DATOS CLAVE VACÍOS (CI o Rol ID) ***
        // =========================================================
        // Usamos .trim() para eliminar espacios en blanco
        if (d4.trim() === "" || d1.trim() === "") { 
            console.warn(`Saltando fila ${index}: El CI (d4) o Rol ID (d1) están vacíos.`);
            return true; // Saltar esta fila
        }
        // =========================================================

        valor = new Array(d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18);
        valores.push(valor);
        console.log("Enviando:", valor);
        
        // Llamada AJAX para insertar.php
        $.post('insertar.php',{d1:d1,d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,d7:d7,d8:d8,d9:d9,d10:d10,d11:d11,d12:d12,d13:d13,d14:d14,d15:d15,d16:d16,d17:d17,d18:d18}, function(datos){
            $('#respuesta').html(datos);
            contador++;
            $('#contador').html("Se registro "+contador+" registros correctamente");
        });
      
    });
  });
</script>


<?php

include ('../../../admin/layout/parte2.php');
include ('../../../layout/mensajes.php');

?>
