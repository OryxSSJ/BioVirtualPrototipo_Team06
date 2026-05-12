<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');

$id_grado   = $_GET['id_grado'];
$id_docente = $_GET['id_docente'];
$id_materia = $_GET['id_materia'];
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h4 class="mb-3"><i class="bi bi-plus-circle"></i> Nueva publicación</h4>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-outline card-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Crear publicación</h5>
                </div>

                <form action="../../app/controllers/classroom/create.php" 
                      method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="grado_id" value="<?=$id_grado?>">
                    <input type="hidden" name="docente_id" value="<?=$id_docente?>">
                    <input type="hidden" name="materia_id" value="<?=$id_materia?>">

                    <div class="card-body">

                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea name="contenido" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo" class="form-control" id="tipo_publicacion" required>
                                <option value="ANUNCIO">Anuncio</option>
                                <option value="TAREA">Tarea</option>
                            </select>
                        </div>

                        <div class="form-group" id="fecha_entrega_box" style="display:none;">
                            <label>Fecha de entrega</label>
                            <input type="datetime-local" name="fecha_entrega" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Archivo (opcional)</label>
                            <input type="file" name="archivo" class="form-control">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="classroom.php?id_grado=<?=$id_grado?>&id_docente=<?=$id_docente?>&id_materia=<?=$id_materia?>" 
                           class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Publicar</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>

<script>
document.getElementById("tipo_publicacion").addEventListener("change", function(){
    document.getElementById("fecha_entrega_box").style.display =
        (this.value === "TAREA") ? "block" : "none";
});
</script>

<?php
include('../../admin/layout/parte2.php');
?>
