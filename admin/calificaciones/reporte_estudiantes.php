<?php
$id_estudiante_get = $_GET['id_estudiante'];
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');

include ('../../app/controllers/estudiantes/listado_de_estudiantes.php');
include ('../../app/controllers/calificaciones/listado_de_calificaciones.php');
$curso = "";
$grupo = "";
$turno = "";

foreach($estudiantes as $estudiante) {
  if($id_estudiante_get == $estudiante['id_estudiante']){
    $nombres = $estudiante['nombres'];
    $apellidos = $estudiante['apellidos'];
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
                <h2>Listado de calificaciones de: <?=$apellidos?> <?=$nombres?></h2>
            </div>
            <br>
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Calificaciones registradas</b></h3>
                            
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th><center>Nro</center></th>
                                    <th><center>Materia</center></th>
                                    <th><center>1er Parcial</center></th>
                                    <th><center>2do Parcial</center></th>
                                    <th><center>3er Parcial</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $contador_calificaciones = 0;
                                $parcial1 = "";
                                $parcial2 = "";
                                $parcial3 = "";
                                foreach ($calificaciones as $calificacion){
                                    if($id_estudiante_get == $calificacion['estudiante_id']){
                                    $contador_calificaciones++; ?>
                                    <tr>
                                      <td><center><?=$contador_calificaciones;?></center></td>
                              
                                      <td><center><?=$calificacion['nombre_materia'];?></center></td>
                                      <td><center><?=$calificacion['parcial1'];;?></center></td>
                                      <td><center><?=$calificacion['parcial2'];;?></center></td>
                                      <td><center><?=$calificacion['parcial3'];?></center></td>
                                      <?php
                                      
                                      ?>
                                      
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                           
                            
                    
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Calificaciones",
                "infoEmpty": "Mostrando 0 a 0 de 0 Calificaciones",
                "infoFiltered": "(Filtrado de _MAX_ total Calificaciones)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Calificaciones",
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