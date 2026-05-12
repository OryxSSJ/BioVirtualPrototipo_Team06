<?php
$id_estudiante = $_GET['id'];
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');

include ('../../app/controllers/estudiantes/datos_de_estudiantes.php');
include ('../../app/controllers/pagos/datos_pago_estudiante.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Pago de Mensualidades</h1>
                <h3><b>Estudiante</b>: <?=$nombres.' '.$apellidos?> <b>Clave identificacion:</b> <?=$ci?></h2>
            </div>
            
            <div class="row">

                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Pagos Registrados</b></h3>
                            <div style="text-align: right">
                                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  <i class="bi bi-cash-stack"></i> Registrar Pago
</button>

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-sm table-hovers">
                                <tr>
                                    <th style="text-align: center;background-color: #0cd0e6;">Nro</th>
                                    <th style="text-align: center; background-color: #0cd0e6;">Mes pagado</th>
                                    <th style="text-align: center; background-color: #0cd0e6;">Monto pagado</th>
                                    <th style="text-align: center; background-color: #0cd0e6;">Fecha de pago</th>
                                    <th style="text-align: center; background-color: #0cd0e6;">Acciones</th>
                                    
                                </tr>
                                <?php
                                $contador = 0;
                                foreach($pagos as $pago){
                                    $estudiante_id = $pago['estudiante_id'];
                                    $id_pago = $pago['id_pago']; ?>
                                    <tr>
                                    <td><center><?=$contador = $contador +1;?></center></td>
                                    <td><center><?=$pago['mes_pagado'];?></center></td>
                                    <td><center><?=$pago['monto_pagado'];?></center></td>
                                    <td><center><?=$pago['fecha_pagado'];?></center></td>
                                    <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="comprobante_pago.php?id=<?=$id_pago;?>&id_estudiante=<?=$estudiante_id;?>" type="button" class="btn btn-warning btn-sm"><i class="bi bi-printer"></i></a>
                                                <a  type="button" data-toggle="modal" data-target="#Modal_editar<?=$id_pago;?>" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                                <!-- Modal 1 -->
<div class="modal fade" id="Modal_editar<?=$id_pago;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0fbf0c">
        <h5 class="modal-title" id="exampleModalLabel">Editar el Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?=APP_URL;?>/app/controllers/pagos/update.php" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="estudiante_id" value="<?=$id_estudiante;?>"hidden>
                        <input type="text" name="id_pago" value="<?=$id_pago;?>"hidden>
                        <input type="text" name="estudiante_id" value="<?=$id_estudiante?>" hidden>
                        <label for="">Estudiante</label>
                        <input type="text" class="form-control" value="<?=$apellidos.' '.$nombres;?>" disabled>

                    </div> 
                    <div class="form-group">
                        <label for="">Clave identidad</label>
                        <input type="text" class="form-control" value="<?=$ci;?>" disabled>

                    </div> 
                    <div class="form-group">
                        <label for="">Mes pagado</label>
                        <select name="mes_pagado" id="" class="form-control">
                            <option value="Enero"<?=$pago['mes_pagado'] == "Enero" ? 'selected' : ''?>>Enero</option>
                            <option value="Febrero"<?=$pago['mes_pagado'] == "Febrero" ? 'selected' : ''?>>Febrero</option>
                            <option value="Marzo"<?=$pago['mes_pagado'] == "Marzo" ? 'selected' : ''?>>Marzo</option>
                            <option value="Abril"<?=$pago['mes_pagado'] == "Abril" ? 'selected' : ''?>>Abril</option>
                            <option value="Mayo"<?=$pago['mes_pagado'] == "Mayo" ? 'selected' : ''?>>Mayo</option>
                            <option value="Junio"<?=$pago['mes_pagado'] == "Junio" ? 'selected' : ''?>>Junio</option>
                            <option value="Julio"<?=$pago['mes_pagado'] == "Julio" ? 'selected' : ''?>>Julio</option>
                            <option value="Agosto"<?=$pago['mes_pagado'] == "Agosto" ? 'selected' : ''?>>Agosto</option>
                            <option value="Septiembre"<?=$pago['mes_pagado'] == "Septiembre" ? 'selected' : ''?>>Septiembre</option>
                            <option value="Octubre"<?=$pago['mes_pagado'] == "Octubre" ? 'selected' : ''?>>Octubre</option>
                            <option value="Noviembre"<?=$pago['mes_pagado'] == "Noviembre" ? 'selected' : ''?>>Noviembre</option>
                            <option value="Diciembre"<?=$pago['mes_pagado'] == "Diciembre" ? 'selected' : ''?>>Diciembre</option>

                        </select>
                    </div> 
                     <div class="form-group">
                        <label for="">Monto pagado</label>
                        <input type="number" name="monto_pagado" class="form-control" value="<?=$pago['monto_pagado']?>" >

                    </div> 
                    <div class="form-group">
                        <label for="">Fecha de pago</label>
                        <input type="date" name="fecha_pagado" value=<?=$pago['fecha_pagado']?> class="form-control"  >

                    </div>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Actualizar</button>
      </div>
      </form>
    </div>
  </div>
</div>

                                                <form action="<?=APP_URL;?>/app/controllers/pagos/delete.php" onclick="preguntar<?=$id_pago;?>(event)" method="post" id="miFormulario<?=$id_pago;?>">
                                                    <input type="text" name="id_pago" value="<?=$id_pago;?>" hidden>
                                                    <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 0px 0px 0px"><i class="bi bi-trash"></i></button>
                                                </form>
                                                <script>
                                                    function preguntar<?=$id_pago;?>(event) {
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            title: 'Eliminar registro',
                                                            text: '¿Desea eliminar este registro?',
                                                            icon: 'question',
                                                            showDenyButton: true,
                                                            confirmButtonText: 'Eliminar',
                                                            confirmButtonColor: '#a5161d',
                                                            denyButtonColor: '#270a0a',
                                                            denyButtonText: 'Cancelar',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                var form = $('#miFormulario<?=$id_pago;?>');
                                                                form.submit();
                                                            }
                                                        });
                                                    }
                                                </script>
                                                
                                            </div>
                                        </td>
                                </tr>
                                
                                    <?php
                                } 
                                ?>
                                
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

<!-- Modal 1 -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0cd0e6">
        <h5 class="modal-title" id="exampleModalLabel">Realizar Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?=APP_URL;?>/app/controllers/pagos/create.php" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="estudiante_id" value="<?=$id_estudiante?>" hidden>
                        <label for="">Estudiante</label>
                        <input type="text" class="form-control" value="<?=$apellidos.' '.$nombres;?>" disabled>

                    </div> 
                    <div class="form-group">
                        <label for="">Clave identidad</label>
                        <input type="text" class="form-control" value="<?=$ci;?>" disabled>

                    </div> 
                    <div class="form-group">
                        <label for="">Mes pagado</label>
                        <select name="mes_pagado" id="" class="form-control">
                            <option value="Enero">Enero</option>
                            <option value="Febrero">Febrero</option>
                            <option value="Marzo">Marzo</option>
                            <option value="Abril">Abril</option>
                            <option value="Mayo">Mayo</option>
                            <option value="Junio">Junio</option>
                            <option value="Julio">Julio</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Septiembre">Septiembre</option>
                            <option value="Octubre">Octubre</option>
                            <option value="Noviembre">Noviembre</option>
                            <option value="Diciembre">Diciembre</option>

                        </select>
                    </div> 
                     <div class="form-group">
                        <label for="">Monto pagado</label>
                        <input type="number" name="monto_pagado" class="form-control" value="0" >

                    </div> 
                    <div class="form-group">
                        <label for="">Fecha de pago</label>
                        <input type="date" name="fecha_pagado" class="form-control"  >

                    </div>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
