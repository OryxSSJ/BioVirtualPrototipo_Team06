<?php
$id_estudiante = $_GET['id'];
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/roles/listado_de_roles.php');
include ('../../app/controllers/niveles/listado_de_niveles.php');
include ('../../app/controllers/grados/listado_de_grados.php');
include ('../../app/controllers/estudiantes/datos_de_estudiantes.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Datos del estudiante: <?=$nombres." ".$apellidos;?></h1>
            </div>
            <br>
            <form action="<?=APP_URL;?>/app/controllers/estudiantes/update.php" method="post">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><b>Actualice datos del estudiante</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" value="<?=$id_usuario?>" name="id_usuario"hidden > 
                                            <input type="text" value="<?=$id_persona?>" name="id_persona" hidden>
                                            <input type="text" value="<?=$id_estudiante?>" name="id_estudiante" hidden>  
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
                                            <input type="text" value="<?=$nombres?>" name="nombres" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <input type="text" value="<?=$apellidos?>" name="apellidos" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Clave Identidad</label>
                                            <input type="number" value="<?=$ci?>" name="ci" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de Nacimiento</label>
                                            <input type="date" value="<?=$fecha_nacimiento?>" name="fecha_nacimiento" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" value="<?=$celular?>" name="celular" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Correo</label>
                                            <input type="email"value="<?=$email?>" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Direccion</label>
                                            <input type="address" value="<?=$direccion?>" name="direccion" class="form-control" required>
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
                    <div class="card card-outline card-success">
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
                                                        <option value="<?=$nivel['id_nivel'];?>"<?=$nivel['id_nivel'] == $id_nivel ? 'selected' : ''?>><?=$nivel['nivel']." - ".$nivel['turno']?></option>
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
                                                    <option value="<?=$grado['id_grado'];?>"<?=$grado['id_grado'] == $id_grado ? 'selected' : ''?>><?=$grado['curso']." | Grupo: ".$grado['paralelo']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Codigo</label>
                                            <input type="text" value="<?=$codigo?>" name="codigo" class="form-control" required>
                                        </div>
                                    </div>

                                    

                                  
                                </div>
                                
                                
                                
                               
                                    
                                    
                                </div>
                                <hr>

                                
                    
                        </div>
                    </div>
                    <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><b>Llene los datos familiares</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        
                                        <div class="form-group">
                                            <input type="text" value="<?=$id_ppff?>" name="id_ppff" hidden>
                                            <label for="">Nombres y apellidos</label>
                                            <input type="text"value="<?=$nombres_apellidos_ppff?>" name="nombres_apellidos_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number"value="<?=$celular_ppff?>" name="celular_ppff" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Ocupacion</label>
                                            <input type="text" value="<?=$ocupacion_ppff?>" name="ocupacion" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombre de referencia</label>
                                            <input type="text" value="<?=$ref_nombre?>" name="ref_nombre" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Parentezco</label>
                                            <input type="text" value="<?=$ref_parentezco?>" name="ref_parentezco" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Telefono de referencia</label>
                                            <input type="number" value="<?=$ref_celular?>" name="ref_celular" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Clave Identidad</label>
                                            <input type="text" value="<?=$ci_ppff?>" name="ci_ppff" class="form-control" required>
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
                    <button type="submit" class="btn btn-primary btn-lg">Actualizar</button>
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
