<?php
$info_estudiante = null;
foreach ($estudiantes as $estudiante) {
    if ($email_sesion == $estudiante["email"]) {
        $info_estudiante = $estudiante;
        break;
    }
}
?>

<?php if ($info_estudiante): ?>
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos del estudiante</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover table-striped table-bordered">
                    <tr><td><b>Nombre:</b></td><td><?= $nombres_sesion_usuario . " " . $apellidos_sesion_usuario; ?></td></tr>
                    <tr><td><b>C.I.:</b></td><td><?= $ci_sesion_usuario; ?></td></tr>
                    <tr><td><b>Grado:</b></td><td><?= $info_estudiante['curso'] . ' ' . $info_estudiante['paralelo']; ?></td></tr>
                    <tr><td><b>Nivel:</b></td><td><?= $info_estudiante['nivel']; ?></td></tr>
                    <tr><td><b>Turno:</b></td><td><?= $info_estudiante['turno']; ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-4 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="bi bi-hospital"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><b>Calificaciones</b></span>
                <a href="<?= APP_URL; ?>/admin/calificaciones/reporte_estudiantes.php?id_estudiante=<?= $info_estudiante['id_estudiante']; ?>" class="btn btn-primary btn-sm">Ingresar</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="bi bi-calendar-range"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><b>Reportes</b></span>
                <a href="<?= APP_URL; ?>/admin/kardex/reporte_estudiante.php?id_estudiante=<?= $info_estudiante['id_estudiante']; ?>" class="btn btn-info btn-sm">Ingresar</a>
            </div>
        </div>
    </div>
</div>
<?php
else: ?>
    <div class="alert alert-warning">No se encontraron datos del estudiante.</div>
<?php
endif; ?>

<div class="row">
    <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
        <div class="inner">
            <!-- Agregamos &nbsp; (espacio en blanco) para forzar la altura del H3 -->
            <h3>&nbsp;</h3>
            
            <p>Classroom</p>
        </div>
        <div class="icon">
            <i class="bi bi-backpack4"></i>
        </div>
        <a href="<?= APP_URL; ?>/admin/estudiantes/materias.php" class="small-box-footer">
            Más información <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
        <div class="inner">
            <!-- Agregamos &nbsp; (espacio en blanco) para forzar la altura del H3 -->
            
            <p>Asistente IA</p>
            <p>Empieza a hablar con AMLO 5</p>
        </div>
        <div class="icon">
            <i class="bi bi-robot"></i>
        </div>
        <a href="<?= APP_URL; ?>/admin/asistente" class="small-box-footer">
            Más información <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
    
</div>
</div>