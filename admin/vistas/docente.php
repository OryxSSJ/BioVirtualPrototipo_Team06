<?php
$info_docente = null;
foreach ($docentes as $docente) {
    if ($docente['email'] == $email_sesion) {
        $info_docente = $docente;
        break;
    }
}
?>

<?php if($info_docente): ?>
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos del docente</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover table-striped table-bordered">
                    <tr><td><b>Nombre:</b></td><td><?=$nombres_sesion_usuario." ".$apellidos_sesion_usuario;?></td></tr>
                    <tr><td><b>Profesión:</b></td><td><?=$info_docente['profesion'];?></td></tr>
                    <tr><td><b>Especialidad:</b></td><td><?=$info_docente['especialidad'];?></td></tr>
                    <tr><td><b>Rol:</b></td><td><?=$info_docente['nombre_rol'];?></td></tr>
                    <tr><td><b>Dirección:</b></td><td><?=$info_docente['direccion'];?></td></tr>
                    <tr><td><b>Antigüedad:</b></td><td><?=$info_docente['antiguedad'];?> años</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="alert alert-warning">No se encontraron datos del docente.</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
        <div class="inner">
            <!-- Agregamos &nbsp; (espacio en blanco) para forzar la altura del H3 -->
            <h3>&nbsp;</h3>
            
            <p>Reportes</p>
        </div>
        <div class="icon">
            <i class="bi bi-file-earmark-bar-graph"></i>
        </div>
        <a href="<?=APP_URL;?>/admin/kardex" class="small-box-footer">
            Más información <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-info">
        <div class="inner">
            <!-- Agregamos &nbsp; (espacio en blanco) para forzar la altura del H3 -->
            <h3>&nbsp;</h3>
            
            <p>Mis cursos</p>
        </div>
        <div class="icon">
            <i class="bi bi-mortarboard"></i>
        </div>
        <a href="<?=APP_URL;?>/admin/calificaciones" class="small-box-footer">
            Más información <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

</div>