<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');

$id_grado   = $_GET['id_grado'];
$id_docente = $_GET['id_docente'];
$id_materia = $_GET['id_materia'];

include('../../app/controllers/classroom/listado_publicaciones.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 d-flex justify-content-between align-items-center">
                <div class="col-sm-6">
                    <h4 class="m-0 text-primary">
                        <i class="bi bi-easel2"></i> Tablón del Classroom
                    </h4>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="publicacion_create.php?id_grado=<?=$id_grado?>&id_docente=<?=$id_docente?>&id_materia=<?=$id_materia?>" 
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Nueva publicación
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <section class="content">
        <div class="container-fluid">

            <?php if (empty($publicaciones)) { ?>
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> No hay publicaciones en este tablón.
                </div>
            <?php } ?>

            <?php foreach ($publicaciones as $pub) { ?>
                <div class="card shadow-sm mb-4 border-left-primary">

                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-chat-left-text text-primary"></i>
                            <?= htmlspecialchars($pub['titulo']) ?>
                        </h5>
                        <small class="text-muted">
                            Publicado el <?= date("d/m/Y H:i A", strtotime($pub['fecha_publicacion'])) ?>
                        </small>
                    </div>

                    <div class="card-body">
    <p><?= nl2br(htmlspecialchars($pub['contenido'])) ?></p>

    <?php if ($pub['archivo']) { ?>
        <a class="btn btn-outline-primary btn-sm" 
           href="<?=APP_URL?>/public/classroom/<?=$pub['archivo']?>" 
           target="_blank">
            <i class="bi bi-paperclip"></i> Ver archivo adjunto
        </a>
    <?php } ?>

    <!-- BOTONES EDITAR & ELIMINAR -->
    <div class="mt-3">
        <a href="editar_publicacion.php?id=<?=$pub['id_publicacion']?>&id_grado=<?=$id_grado?>&id_docente=<?=$id_docente?>&id_materia=<?=$id_materia?>" 
           class="btn btn-warning btn-sm text-white">
            <i class="bi bi-pencil"></i> Editar
        </a>

        <form action="<?=APP_URL;?>/app/controllers/classroom/delete.php" 
      onclick="preguntar<?=$pub['id_publicacion'];?>(event)" 
      method="post" 
      id="formPub<?=$pub['id_publicacion'];?>"
      style="display:inline-block">

    <input type="hidden" name="id_publicacion" value="<?=$pub['id_publicacion'];?>">

    <button type="submit" class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i> Eliminar
    </button>
</form>
<script>
function preguntar<?=$pub['id_publicacion'];?>(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Eliminar publicación',
        text: '¿Deseas eliminar esta publicación?',
        icon: 'warning',
        showDenyButton: true,
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#a5161d',
        denyButtonColor: '#270a0a',
        denyButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPub<?=$pub['id_publicacion'];?>').submit();
        }
    });
}
</script>
    </div>

    <?php if ($pub['tipo'] === "TAREA") { ?>
        <div class="alert alert-warning mt-3">
            <i class="bi bi-clock-history"></i>
            Fecha de entrega: <?= date("d/m/Y H:i A", strtotime($pub['fecha_entrega'])) ?>
        </div>

        <a href="ver_tarea.php?id_publicacion=<?=$pub['id_publicacion']?>" 
           class="btn btn-success btn-sm">
            <i class="bi bi-clipboard-check"></i> Ver tarea
        </a>
    <?php } ?>
</div>


                </div>
            <?php } ?>

        </div>
    </section>
</div>

<?php
include('../../admin/layout/parte2.php');
include('../../layout/mensajes.php');
?>
