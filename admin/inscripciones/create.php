<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/roles/listado_de_roles.php');
include ('../../app/controllers/niveles/listado_de_niveles.php');
include ('../../app/controllers/grados/listado_de_grados.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Creación de un nuevo estudiante</h1>
            </div>
            <br>
            <form action="<?=APP_URL;?>/app/controllers/inscripciones/create.php" method="post">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Llene los datos del estudiante</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombre del rol</label>
                                            <a href="<?=APP_URL;?>/admin/roles/create.php" style="margin-left: 5px" class="btn btn-primary btn-sm"><i class="bi bi-file-plus"></i></a>
                                            
                                            <div class="form-inline">
                                                <select name="rol_id" id="" class="form-control">
                                                    <?php
                                                    foreach ($roles as $role){ ?>
                                                        <option value="<?=$role['id_rol'];?>"<?=$role['nombre_rol'] =="ESTUDIANTE" ? 'selected' : ''?>disabled><?=$role['nombre_rol'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" name="nombres" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <input type="text" name="apellidos" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Clave Identidad</label>
                                            <input type="number" name="ci" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de Nacimiento</label>
                                            <input type="date" name="fecha_nacimiento" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" name="celular" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Correo</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Direccion</label>
                                            <input type="address" name="direccion" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                
                                
                               
                                    
                                    
                                </div>
                                <hr>

                                
                    
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="container">

                <div class="col-md-13">
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title"><b>Llene los datos academicos</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nivel</label>
                                            
                                            <div class="form-inline">
                                                <select name="id_nivel" id="" class="form-control">
                                                    <?php
                                                    foreach ($niveles as $nivel){ ?>
                                                        <option value="<?=$nivel['id_nivel'];?>"><?=$nivel['nivel']." - ".$nivel['turno'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Grado</label>
                                            <select name="id_grado" id="" class="form-control">
                                                    <?php
                                                    foreach ($grados as $grado){ ?>
                                                        <option value="<?=$grado['id_grado'];?>"><?=$grado['curso']." | Grupo ".$grado['paralelo'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Codigo</label>
                                            <input type="text" name="codigo" class="form-control" required>
                                        </div>
                                    </div>

                                    

                                  
                                </div>
                                
                                
                                
                               
                                    
                                    
                                </div>
                                <hr>

                                
                    
                        </div>
                    </div>
                    <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <h3 class="card-title"><b>Llene los datos familiares</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        
                                        <div class="form-group">
                                            <label for="">Nombres y apellidos</label>
                                            <input type="text" name="nombre_apellidos_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" name="celular_ppff" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Ocupacion</label>
                                            <input type="text" name="ocupacion" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombre de referencia</label>
                                            <input type="text" name="ref_nombre" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Parentezco</label>
                                            <input type="text" name="ref_parentezco" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Telefono de referencia</label>
                                            <input type="number" name="ref_celular" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Clave Identidad</label>
                                            <input type="text" name="ci_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
             </div>        
                                </div>
                                <hr>
                        </div>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                    <a href="<?=APP_URL;?>/admin/estudiantes"class="btn btn-secondary btn-lg">Cancelar</a>
                </div>
                </div>
                </div>
             
            </form>


            

            
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
