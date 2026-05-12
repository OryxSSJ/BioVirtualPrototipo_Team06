<?php
// Consulta específica para obtener rol y profesión de roles administrativos/otros
$sql_datos = "SELECT nombre_rol, direccion, profesion FROM usuarios as usu 
              INNER JOIN roles as rol ON rol.id_rol = usu.rol_id
              INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
              WHERE usu.estado='1' AND usu.email = :email";
$query_datos = $pdo->prepare($sql_datos);
$query_datos->bindParam(':email', $email_sesion);
$query_datos->execute();
$dato_usuario = $query_datos->fetch(PDO::FETCH_ASSOC);

if(!$dato_usuario){
    $dato_usuario = ['nombre_rol' => $rol_sesion_usuario, 'profesion' => 'N/A', 'direccion' => 'N/A'];
}
?>

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos del usuario</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover table-striped table-bordered">
                    <tr><td><b>Nombre y apellidos:</b></td><td><?=$nombres_sesion_usuario." ".$apellidos_sesion_usuario;?></td></tr>
                    <tr><td><b>Rol:</b></td><td><?=$dato_usuario['nombre_rol'];?></td></tr>
                    <tr><td><b>Email:</b></td><td><?=$email_sesion;?></td></tr>
                    <tr><td><b>Profesión:</b></td><td><?=$dato_usuario['profesion'];?></td></tr>
                    <tr><td><b>Dirección:</b></td><td><?=$dato_usuario['direccion'];?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
         <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
        <div class="inner">
            <!-- Agregamos &nbsp; (espacio en blanco) para forzar la altura del H3 -->
            <h3>&nbsp;</h3>
            
            <p>Pagos</p>
        </div>
        <div class="icon">
            <i class="bi bi-credit-card-2-back"></i>
        </div>
        <a href="<?=APP_URL;?>/admin/pagos" class="small-box-footer">
            Más información <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>


<div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= count($estudiantes); ?></h3>
                <p>Estudiantes</p>
            </div>
            <div class="icon"><i class="bi bi-backpack2"></i></div>
            <a href="<?=APP_URL;?>/admin/estudiantes" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>