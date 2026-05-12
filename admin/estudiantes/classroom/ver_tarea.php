<?php
include('../../../app/config.php');
include('../../../admin/layout/parte1.php');

// 1. Validar parámetros
$id_publicacion = $_GET['id'] ?? null;

if (!$id_publicacion) {
    echo "Error: No se especificó la tarea."; exit;
}

// 2. Obtener ID del estudiante (Seguridad: Usamos la lógica del doble JOIN)
$email_sesion = $_SESSION['sesion_email'];
$query_est = $pdo->prepare("SELECT estudiantes.id_estudiante 
                            FROM estudiantes 
                            INNER JOIN personas ON estudiantes.persona_id = personas.id_persona
                            INNER JOIN usuarios ON personas.usuario_id = usuarios.id_usuario
                            WHERE usuarios.email = :email");
$query_est->bindParam(':email', $email_sesion);
$query_est->execute();
$estudiante = $query_est->fetch(PDO::FETCH_ASSOC);
$id_estudiante = $estudiante['id_estudiante'];

// 3. Consulta Específica: Tarea + Estado de Entrega
$sql = "SELECT 
            p.*,
            m.nombre_materia,
            e.id_envio,
            e.archivo as archivo_enviado,
            e.comentario as comentario_enviado,
            e.fecha_envio,
            e.calificacion,
            e.retroalimentacion
        FROM publicaciones p
        INNER JOIN materias m ON p.materia_id = m.id_materia
        LEFT JOIN envios_publicacion e 
            ON p.id_publicacion = e.publicacion_id 
            AND e.estudiante_id = :id_est
        WHERE p.id_publicacion = :id_pub";

$query = $pdo->prepare($sql);
$query->bindParam(':id_est', $id_estudiante);
$query->bindParam(':id_pub', $id_publicacion);
$query->execute();
$tarea = $query->fetch(PDO::FETCH_ASSOC);

if (!$tarea) { echo "Tarea no encontrada"; exit; }

// Variable auxiliar para saber si ya entregó
$ya_entregado = !empty($tarea['id_envio']);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detalles de la Tarea</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="col-sm-6 text-right">
    <button onclick="history.back()" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </button>
</div>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-md-8">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title text-primary font-weight-bold">
                                <i class="bi bi-clipboard-data"></i> <?= htmlspecialchars($tarea['titulo']) ?>
                            </h3>
                            <div class="card-tools text-muted">
                                <small>Publicado: <?= date("d/m/Y", strtotime($tarea['fecha_publicacion'])) ?></small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="text-secondary">Instrucciones:</h6>
                            <div class="p-3 bg-light border rounded mb-3">
                                <?= nl2br(htmlspecialchars($tarea['contenido'])) ?>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <strong><i class="bi bi-book"></i> Materia:</strong> <?= $tarea['nombre_materia'] ?>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong><i class="bi bi-calendar-x"></i> Fecha Límite:</strong> 
                                    <span class="badge badge-danger"><?= date("d/m/Y H:i A", strtotime($tarea['fecha_entrega'])) ?></span>
                                </div>
                            </div>

                            <?php if ($tarea['archivo']) { ?>
                                <hr>
                                <h6>Material de apoyo:</h6>
                                <a href="<?=APP_URL?>/public/classroom/<?=$tarea['archivo']?>" target="_blank" class="btn btn-outline-info text-left">
                                    <i class="bi bi-file-earmark-arrow-down"></i> Descargar material del docente
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    
                    <?php if ($ya_entregado) { ?>
                        <div class="card card-success card-outline shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title"><i class="bi bi-check-circle-fill"></i> Tu Trabajo</h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success text-center">
                                    <strong>¡Tarea Entregada!</strong><br>
                                    <small>Enviado el: <?= date("d/m/Y H:i", strtotime($tarea['fecha_envio'])) ?></small>
                                </div>

                                <p><strong>Tu archivo:</strong></p>
                                <a href="<?=APP_URL?>/public/archivos/tareas/<?=$tarea['archivo_enviado']?>" target="_blank" class="btn btn-light btn-block border text-left">
                                    <i class="bi bi-file-earmark-check"></i> Ver mi archivo enviado
                                </a>

                                <?php if($tarea['comentario_enviado']){ ?>
                                    <p class="mt-2"><small><strong>Tu comentario:</strong> <?= htmlspecialchars($tarea['comentario_enviado']) ?></small></p>
                                <?php } ?>

                                <hr>
                                <h4>Calificación:</h4>
                                <?php if ($tarea['calificacion']) { ?>
                                    <h2 class="text-center text-primary display-4"><?= $tarea['calificacion'] ?>/100</h2>
                                    <?php if($tarea['retroalimentacion']){ ?>
                                        <div class="alert alert-warning">
                                            <strong><i class="bi bi-chat-quote"></i> Feedback del profe:</strong><br>
                                            <?= htmlspecialchars($tarea['retroalimentacion']) ?>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="text-center text-muted">
                                        <i>Pendiente de revisar por el docente.</i>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    <?php } else { 
                        $fecha_actual = date('Y-m-d H:i:s');
                        $plazo_vencido = ($tarea['fecha_entrega'] != null && $fecha_actual > $tarea['fecha_entrega']);
                        ?>
                        
                        <div class="card shadow-sm elevation-2">
        <div class="card-header bg-white">
            <h3 class="card-title">Tu trabajo</h3>
            <div class="card-tools">
                <?php if ($plazo_vencido) { ?>
                    <span class="badge badge-danger">Cerrado</span>
                <?php } else { ?>
                    <span class="badge badge-warning">Sin entregar</span>
                <?php } ?>
            </div>
        </div>
        <div class="card-body">
            
            <?php if ($plazo_vencido) { ?>
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i><br>
                    <strong>El plazo de entrega ha vencido.</strong><br>
                    <small>La fecha límite fue: <?= date("d/m/Y H:i A", strtotime($tarea['fecha_entrega'])) ?></small>
                    <br><br>
                    Comunícate con tu docente si necesitas una extensión.
                </div>

            <?php } else { ?>
                
                <form action="<?=APP_URL;?>/app/controllers/estudiantes/guardar_entrega.php" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="id_publicacion" value="<?=$id_publicacion?>">
                    <input type="hidden" name="id_materia" value="<?=$tarea['materia_id']?>">

                    <div class="form-group">
                        <label for="file"><i class="bi bi-plus-lg"></i> Añadir archivo o crear</label>
                        <div class="custom-file">
                            <input type="file" name="archivo_tarea" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Seleccionar archivo</label>
                        </div>
                        <small class="text-muted">Formatos: PDF, Word, IMG, ZIP.</small>
                    </div>

                    <div class="form-group">
                        <label>Comentario privado (opcional)</label>
                        <textarea name="comentario" class="form-control" rows="2" placeholder="Ej: Profe, adjunto mi tarea..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="bi bi-send-fill"></i> Entregar tarea
                    </button>

                </form>

            <?php } // Fin del if plazo_vencido ?>

        </div>
    </div>

<?php } ?>
                    
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

<?php include('../../../admin/layout/parte2.php'); ?>