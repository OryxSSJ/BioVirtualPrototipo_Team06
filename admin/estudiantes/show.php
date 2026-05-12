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
                <h1>Estudiante: <?=$nombres." ".$apellidos;?></h1>
            </div>
            <br>
            
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Datos del estudiante</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombre del rol</label>
                                            <div class="form-inline">
                                                
                                                <p><?=$nombre_rol;?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <p><?=$nombres;?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <p><?=$apellidos;?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Clave Identidad</label>
                                            <p><?=$ci;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de Nacimiento</label>
                                            <p><?=$fecha_nacimiento;?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <p><?=$celular;?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Correo</label>
                                            <p><?=$email;?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Direccion</label>
                                            <p><?=$direccion;?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <p><?php
                                            if($estado == "1") echo"ACTIVO";
                                            else echo"INACTIVO";
                                            ?></p>
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
                            <h3 class="card-title"><b>Datos academicos</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nivel</label>
                                            
                                            <div class="form-inline">
                                                <p><?=$id_nivel." - ".$nivel." | ".$turno;?></p>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Grado</label>
                                            <p><?=$curso." | Grupo: ".$paralelo;?></p>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Codigo</label>
                                            <p><?=$codigo;?></p>
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
                            <h3 class="card-title"><b>Datos familiares</b></h3>
                        </div>
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-3">
                                        
                                        <div class="form-group">
                                            <label for="">Nombres y apellidos</label>
                                            <p><?=$nombres_apellidos_ppff;?></p>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <p><?=$celular_ppff;?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Ocupacion</label>
                                            <p><?=$ocupacion_ppff;?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombre de referencia</label>
                                            <p><?=$ref_nombre;?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Parentezco</label>
                                            <p><?=$ref_parentezco;?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Telefono de referencia</label>
                                            <p><?=$ref_celular;?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Clave Identidad</label>
                                            <p><?=$ci_ppff;?></p>
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
                    <a href="<?=APP_URL;?>/admin/estudiantes"class="btn btn-success btn-lg">Volver</a>
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
