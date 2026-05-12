<?php
include('../../config.php');

$id_publicacion = $_POST['id_publicacion'];
$grado_id       = $_POST['grado_id'];
$docente_id     = $_POST['docente_id'];
$materia_id     = $_POST['materia_id'];
$titulo         = $_POST['titulo'];
$contenido      = $_POST['contenido'];
$tipo           = $_POST['tipo'];
$fecha_entrega  = $_POST['fecha_entrega'] ?? NULL;

// Buscar archivo anterior
$sqlOld = $pdo->prepare("SELECT archivo FROM publicaciones WHERE id_publicacion = :id");
$sqlOld->bindParam(':id', $id_publicacion);
$sqlOld->execute();
$old = $sqlOld->fetch(PDO::FETCH_ASSOC);

$archivo = $old['archivo'];

// Si sube uno nuevo → reemplazar
if(!empty($_FILES['archivo']['name'])){
    $ruta = '../../../public/classroom/';
    $newName = date("YmdHis")."_".$_FILES['archivo']['name'];
    move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta.$newName);
    $archivo = $newName;
}

try {
    $sql = "UPDATE publicaciones SET 
            titulo=:titulo,
            contenido=:contenido,
            tipo=:tipo,
            fecha_entrega=:fecha_entrega,
            archivo=:archivo
            WHERE id_publicacion=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo',$titulo);
    $stmt->bindParam(':contenido',$contenido);
    $stmt->bindParam(':tipo',$tipo);
    $stmt->bindParam(':fecha_entrega',$fecha_entrega);
    $stmt->bindParam(':archivo',$archivo);
    $stmt->bindParam(':id',$id_publicacion);

    if($stmt->execute()){
        header("Location: ../../../admin/calificaciones/classroom.php?id_grado=$grado_id&id_docente=$docente_id&id_materia=$materia_id&msg=updated");
    } else {
        echo "Error al actualizar";
    }

} catch(PDOException $e){
    echo "Error: ".$e->getMessage();
}
