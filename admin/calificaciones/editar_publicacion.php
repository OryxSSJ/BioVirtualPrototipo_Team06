<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');

$id_publicacion = $_GET['id'];
$id_grado       = $_GET['id_grado'];
$id_docente     = $_GET['id_docente'];
$id_materia     = $_GET['id_materia'];

// Obtener datos de la publicación
$sql = $pdo->prepare("SELECT * FROM publicaciones WHERE id_publicacion = :id");
$sql->bindParam(':id', $id_publicacion);
$sql->execute();
$pub = $sql->fetch(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="content-header">
        <h4><i class="bi bi-pencil-square"></i> Editar publicación</h4>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-outline card-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Modificar datos</h5>
                </div>

                <form action="../../app/controllers/classroom/update.php" 
                      method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id_publicacion" value="<?=$id_publicacion?>">
                    <input type="hidden" name="grado_id" value="<?=$id_grado?>">
                    <input type="hidden" name="docente_id" value="<?=$id_docente?>">
                    <input type="hidden" name="materia_id" value="<?=$id_materia?>">

                    <div class="card-body">

                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="titulo" class="form-control" value="<?=$pub['titulo']?>" required>
                        </div>

                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea name="contenido" class="form-control" rows="5"><?=$pub['contenido']?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo" class="form-control" id="tipo_publicacion">
                                <option value="ANUNCIO" <?=$pub['tipo']=='ANUNCIO'?'selected':''?>>Anuncio</option>
                                <option value="TAREA" <?=$pub['tipo']=='TAREA'?'selected':''?>>Tarea</option>
                            </select>
                        </div>

                        <div class="form-group" id="fecha_entrega_box" style="display:<?=$pub['tipo']=='TAREA'?'block':'none'?>">
                            <label>Fecha de entrega</label>
                            <input type="datetime-local" name="fecha_entrega" class="form-control" 
                                   value="<?=$pub['fecha_entrega']?>">
                        </div>

                        <div class="form-group">
                            <label>Archivo actual:</label><br>
                            <?php if($pub['archivo'] != ""): ?>
                                <a href="../../../public/classroom/<?=$pub['archivo']?>" target="_blank">
                                    <?=$pub['archivo']?>
                                </a>
                            <?php else: ?>
                                <span>No hay archivo adjunto</span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Subir archivo nuevo (opcional)</label>
                            <input type="file" name="archivo" class="form-control">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="classroom.php?id_grado=<?=$id_grado?>&id_docente=<?=$id_docente?>&id_materia=<?=$id_materia?>"
                           class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-white">Actualizar</button>
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

<?php include('../../admin/layout/parte2.php'); ?>
