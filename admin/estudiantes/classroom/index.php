<?php
include('../../../app/config.php');
include ('../../../admin/layout/parte1.php');

// Validar que venga la materia
if(!isset($_GET['id_materia'])){
    echo "<h1>Error: Falta seleccionar materia</h1>"; exit;
}

// Incluimos el controlador que acabamos de crear
include('../../../app/controllers/estudiantes/listado_publicaciones.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h4 class="m-0 text-dark">
                <i class="bi bi-journal-album"></i> Classroom: <b><?= htmlspecialchars($nombre_materia) ?></b>
            </h4>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <?php if (empty($publicaciones)) { ?>
                <div class="alert alert-info text-center mt-4">
                    <i class="bi bi-emoji-smile"></i> No hay publicaciones ni tareas en esta materia todavía.
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-md-10 offset-md-1">
                    
                    <?php foreach ($publicaciones as $pub) { ?>
                        <!-- Diferenciamos visualmente si es TAREA o solo ANUNCIO -->
                        <div class="card shadow-sm mb-4 border-left-<?= $pub['tipo']=='TAREA' ? 'warning' : 'info' ?>">
                            
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0 text-<?= $pub['tipo']=='TAREA' ? 'dark' : 'info' ?>">
                                        <?php if($pub['tipo']=='TAREA'){ ?>
                                            <i class="bi bi-clipboard-check text-warning"></i> 
                                        <?php } else { ?>
                                            <i class="bi bi-megaphone text-info"></i>
                                        <?php } ?>
                                        <?= htmlspecialchars($pub['titulo']) ?>
                                    </h5>
                                    <br>
                                    <small class="text-muted">
                                        <?= date("d/m/Y", strtotime($pub['fecha_publicacion'])) ?>
                                    </small>
                                </div>
                                
                                <!-- Badge de estado si es tarea -->
                                <?php if($pub['tipo'] == 'TAREA') { ?>
                                    <?php if($pub['id_envio']) { ?>
                                        <span class="badge badge-success px-3 py-2">
                                            <i class="bi bi-check-circle"></i> Entregado
                                            <?= $pub['calificacion'] ? '('.$pub['calificacion'].'/100)' : '' ?>
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger px-3 py-2">
                                            <i class="bi bi-circle"></i> Pendiente
                                        </span>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <div class="card-body">
                                <p class="card-text"><?= nl2br(htmlspecialchars($pub['contenido'])) ?></p>

                                <?php if ($pub['archivo']) { ?>
                                    <a href="<?=APP_URL?>/public/classroom/<?=$pub['archivo']?>" 
                                       target="_blank" class="btn btn-outline-secondary btn-sm mb-3">
                                        <i class="bi bi-paperclip"></i> Ver material adjunto
                                    </a>
                                <?php } ?>

                                <!-- Botón de Acción -->
                                <?php if ($pub['tipo'] === "TAREA") { ?>
                                    <div class="alert alert-light border mt-2">
                                        <small><i class="bi bi-calendar-event"></i> Fecha de entrega: 
                                            <b class="text-danger"><?= date("d/m/Y H:i A", strtotime($pub['fecha_entrega'])) ?></b>
                                        </small>
                                        
                                        <div class="mt-2">
                                            <!-- ENLACE CORREGIDO: Apunta al archivo ver_tarea del estudiante -->
                                            <a href="ver_tarea.php?id=<?=$pub['id_publicacion']?>" 
                                               class="btn btn-primary btn-block">
                                                <?php if($pub['id_envio']) { ?>
                                                    <i class="bi bi-eye"></i> Ver mi entrega / Calificación
                                                <?php } else { ?>
                                                    <i class="bi bi-upload"></i> Subir Tarea
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>
    </section>
</div>

<?php include('../../../admin/layout/parte2.php'); ?>