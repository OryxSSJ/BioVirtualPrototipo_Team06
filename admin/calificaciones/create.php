<?php
$id_grado_get = $_GET['id_grado'];
$id_docente_get = $_GET['id_docente'];
$id_materia_get = $_GET['id_materia'];
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');

include ('../../app/controllers/estudiantes/listado_de_estudiantes.php');
include ('../../app/controllers/calificaciones/listado_de_calificaciones.php');
$curso = "";
$grupo = "";
$turno = "";
foreach($estudiantes as $estudiante) {
  if($id_grado_get == $estudiante['id_grado']){
    $curso = $estudiante['curso'];
    $grupo = $estudiante['paralelo'];
    $turno = $estudiante['turno'];
    break;
  }
  
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h2>Listado de estudiantes grado: <?=$curso?> Grupo: <?=$grupo?></h2>
            </div>
            <br>
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Estudiantes registrados</b></h3>
                            
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th><center>Nro</center></th>
                                    <th><center>Nombre del estudiante</center></th>
                                    <th><center>Nivel</center></th>
                                    <th><center>Turno</center></th>
                                    <th><center>Grado y Grupo</center></th>
                                    <th><center>1er Parcial</center></th>
                                    <th><center>2do Parcial</center></th>
                                    <th><center>3er Parcial</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $contador_estudiantes = 0;
                                
                                foreach ($estudiantes as $estudiante){
                                    if($id_grado_get == $estudiante['id_grado'] && $estudiante['turno'] == $turno){
                                    $id_estudiante = $estudiante['id_estudiante'];
                                    $contador_estudiantes++; ?>
                                    <tr>
                                      <td style="text-align: center">
                                      <input type="text" id="estudiante_<?=$contador_estudiantes;?>" value="<?=$id_estudiante;?>"hidden>  
                                      <?=$contador_estudiantes?></td>
                                      <td><center><?=$estudiante['apellidos']." ".$estudiante['nombres'];?></center></td>
                                      <td><center><?=$estudiante['nivel'];?></center></td>
                                      <td><center><?=$estudiante['turno'];?></center></td>
                                      <td><center><?=$estudiante['curso']." - ".$estudiante['paralelo'];?></center></td>
                                      <?php
                                        $parcial1 = "";
                                        $parcial2 = "";
                                        $parcial3 = "";
                                      foreach($calificaciones as $calificacion) {
                                        if(($calificacion['docente_id'] == $id_docente_get)
                                            && ($calificacion['estudiante_id'] == $id_estudiante)
                                            && ($calificacion['materia_id'] == $id_materia_get)){
                                            $parcial1 = $calificacion['parcial1'];
                                            $parcial2 = $calificacion['parcial2'];
                                            $parcial3 = $calificacion['parcial3'];
                                        }
                                            
                                      }
                                      ?>
                                      <td>
                                      <input style="text-align: center" value="<?=$parcial1;?>" id="parcial1_<?=$contador_estudiantes?>" type="number" class="form-control">
                                      </td>
                                      <td>
                                      <input style="text-align: center" value="<?=$parcial2;?>" id="parcial2_<?=$contador_estudiantes;?>" type="number" class="form-control">
                                      </td>
                                      <td>
                                      <input style="text-align: center" value="<?=$parcial3;?>" id="parcial3_<?=$contador_estudiantes;?>" type="number" class="form-control">
                                      </td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <button class="btn btn-primary btn-lg" id="btn-guardar">Guardar notas</button>
                            <script>
                              $('#btn-guardar').click(function(){
                                var n = '<?=$contador_estudiantes;?>';
                                var i = 0;
                               
                                for(i = 1; i<=n; i++){
                                  var a = '#parcial1_' + i;
                                  var parcial1 = $(a).val();

                                  var b = '#parcial2_' + i;
                                  var parcial2 = $(b).val();

                                  var c = '#parcial3_' + i;
                                  var parcial3 = $(c).val();

                                  var d = '#estudiante_'+i;
                                  var id_estudiante = $(d).val();

                                  var id_docente = '<?=$id_docente_get;?>';
                                  var id_materia = '<?=$id_materia_get;?>';
                                  var url = "../../app/controllers/calificaciones/create.php";
                                  
                                  $.get(url,{id_docente:id_docente, id_estudiante:id_estudiante, id_materia:id_materia, parcial1:parcial1, parcial2:parcial2, parcial3:parcial3},function(datos){
                                    $('#respuesta').html(datos);
                                    
                                  });
                                }
                                Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Nota cargada",
                                        showConfirmButton: false,
                                        timer: 5000
                                        });
                                        });
                            </script>
                            <div id="respuesta" hidden></div>
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

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');

?>

<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay informacion",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Estudiantes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Estudiantes",
                "infoFiltered": "(Filtrado de _MAX_ total Estudiantes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Estudiantes",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                },{
                    extend: 'csv'
                },{
                    extend: 'excel'
                },{
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>