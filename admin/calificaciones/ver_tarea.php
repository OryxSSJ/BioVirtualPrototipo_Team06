<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');

// 1. Validar que el ID exista
$id_tarea = $_GET['id_publicacion'] ?? null;

if (!$id_tarea) {
    echo "<div class='content-wrapper'><div class='container-fluid mt-4'><div class='alert alert-danger'>Error: No se ha especificado un ID de tarea.</div></div></div>";
    include('../../admin/layout/parte2.php');
    exit;
}

// 2. Consulta de la tarea
$sql = $pdo->prepare("SELECT * FROM publicaciones WHERE id_publicacion = :id");
$sql->bindParam(':id', $id_tarea);
$sql->execute();
$tarea = $sql->fetch(PDO::FETCH_ASSOC);

// 3. VALIDACIÓN CRÍTICA: Si no encuentra la tarea, detenemos la ejecución aquí
if (!$tarea) {
    echo "<div class='content-wrapper'><div class='container-fluid mt-4'><div class='alert alert-danger'>Error: La tarea solicitada no existe o ha sido eliminada.</div></div></div>";
    include('../../admin/layout/parte2.php');
    exit;
}

// Consulta de envíos (Agregué e.publicacion_id al SELECT para que funcione el modal)
$sql2 = $pdo->prepare("
    SELECT 
        e.id_envio,
        e.publicacion_id, 
        est.id_estudiante,
        per.nombres,
        per.apellidos,
        e.archivo,
        e.fecha_envio,
        e.calificacion,
        e.retroalimentacion
    FROM envios_publicacion e
    INNER JOIN estudiantes est ON est.id_estudiante = e.estudiante_id
    INNER JOIN personas per ON per.id_persona = est.persona_id
    WHERE e.publicacion_id = :id
    ORDER BY per.apellidos ASC
");
$sql2->bindParam(':id', $id_tarea);
$sql2->execute();
$envios = $sql2->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h4>
                <i class="bi bi-clipboard-check"></i> Detalle de Tarea
            </h4>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card shadow-sm border-left-primary mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= htmlspecialchars($tarea['titulo'] ?? '') ?></h5>
                </div>

                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($tarea['contenido'] ?? '')) ?></p>

                    <?php if(!empty($tarea['archivo'])) { ?>
                        <a class="btn btn-outline-primary btn-sm" 
                           href="<?=APP_URL?>/public/classroom/<?=$tarea['archivo']?>" 
                           target="_blank">
                            <i class="bi bi-paperclip"></i> Ver archivo de la tarea
                        </a>
                    <?php } ?>

                    <?php if(!empty($tarea['fecha_entrega'])) { ?>
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-clock-history"></i> 
                            Fecha de entrega: <?= date("d/m/Y H:i A", strtotime($tarea['fecha_entrega'])) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-people"></i> Envíos de estudiantes
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Estudiante</th>
                                <th>Archivo</th>
                                <th>Fecha envío</th>
                                <th>Calificación</th>
                                <th>Retroalimentación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                          <?php if(count($envios)==0){ ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                   <i class="bi bi-inbox"></i> No hay entregas todavía.
                                </td>
                             </tr>
                          <?php } ?>
                          
                            <?php foreach($envios as $env) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($env['apellidos']." ".$env['nombres']) ?></td>

                                    <td>
                                     <?php if(!empty($env['archivo'])) { ?>
                                     <a href="<?=APP_URL?>/public/archivos/tareas/<?=$env['archivo']?>" 
                                                          target="_blank" 
                                                          class="btn btn-success btn-sm"
                                                          title="Ver archivo entregado">
                                    <i class="bi bi-file-earmark-arrow-down"></i> Ver Archivo
                                     </a>
                                     <?php } else { ?>
                                     <span class="badge badge-secondary">Sin archivo</span>
                                     <?php } ?>
                                     </td>

                                    <td><?= date("d/m/Y H:i A", strtotime($env['fecha_envio'])) ?></td>

                                    <td><?= $env['calificacion'] ?? '—' ?></td>

                                    <td><?= nl2br(htmlspecialchars($env['retroalimentacion'] ?? '—')) ?></td>

                                    <td>
                                        <button class="btn btn-primary btn-sm"
                                                data-toggle="modal"
                                                data-target="#calificar<?=$env['id_envio']?>">
            <i class="bi bi-pencil-square"></i>
        </button>

        <div class="modal fade" id="calificar<?=$env['id_envio']?>" tabindex="-1">
            <div class="modal-dialog">
                <form action="<?=APP_URL;?>/app/controllers/Classroom/calificar.php" method="POST">
                    <input type="hidden" name="id_envio" value="<?=$env['id_envio']?>">
                    <input type="hidden" name="id_publicacion" value="<?=$env['publicacion_id']?>">

                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Calificar a <?= htmlspecialchars($env['nombres']) ?></h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body text-left"> <div class="form-group">
                                <label>Nota (sobre 100):</label>
                                <input type="number" name="calificacion" class="form-control" 
                                       value="<?=$env['calificacion'] ?? '' ?>" required max="100">
                            </div>
                            <div class="form-group">
                                <label>Comentarios / Feedback:</label>
                                <textarea name="retroalimentacion" class="form-control" rows="3"><?=$env['retroalimentacion'] ?? '' ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Nota</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </td>
</tr>

                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </section>

</div>

<?php include('../../admin/layout/parte2.php'); ?>