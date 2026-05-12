<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');

include ('../../app/controllers/docentes/listado_de_docentes.php');
include('../../app/controllers/docentes/listado_de_asignaciones.php')
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Cursos asignados</h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cursos registrados</h3>
                            
                        </div>
                        <div class="card-body">
                            <table  class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th><center>Nro</center></th>
                                    <th><center>Materia</center></th>
                                    <th><center>Nivel</center></th>
                                    <th><center>Grado</center></th>
                                    <th><center>Grupo</center></th>
                                    <th><center>Turno</center></th>
                                    <th><center>Acciones</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $contador = 0;
                                  foreach($asignaciones as $asignacion){
                                    $id_grado = $asignacion['id_grado'];
                                  if($email_sesion == $asignacion['email']){ 
                                    $contador++;
                                    ?>
                                     <tr>
                                      <td><center><?=$contador?></center></td>
                                      <td><center><?=$asignacion['nombre_materia']?></center></td>
                                      <td><center><?=$asignacion['nivel']?></center></td>
                                      <td><center><?=$asignacion['curso']?></center></td>
                                      <td><center><?=$asignacion['paralelo']?></center></td>
                                      <td><center><?=$asignacion['turno']?></center></td>
                                      <td style="text-align: center">

                                        <!-- SUBIR CALIFICACIONES -->
                                        <a href="create.php?id_grado=<?=$id_grado?>&&id_docente=<?=$asignacion['docente_id']?>&&id_materia=<?=$asignacion['materia_id']?>" 
                                        class="btn btn-primary btn-sm">
                                            <i class="bi bi-file-earmark-check"></i> Subir notas
                                        </a>

                                        <!-- TABLÓN / CLASSROOM -->
                                        <a href="classroom.php?id_grado=<?=$id_grado?>&id_docente=<?=$asignacion['docente_id']?>&id_materia=<?=$asignacion['materia_id']?>" 
                                        class="btn btn-warning btn-sm">
                                            <i class="bi bi-chat-dots"></i> Tablón
                                        </a> 
                                       </td>

                                     </tr>
                                     <?php
                                  }
                                  }
                                  ?>
                                    
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                
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

