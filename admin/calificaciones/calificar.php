<?php
include('../../config.php');

$id_envio = $_POST['id_envio'];
$id_publicacion = $_POST['id_publicacion'];
$calificacion = $_POST['calificacion'];
$retroalimentacion = $_POST['retroalimentacion'];

$sql = $pdo->prepare("
    UPDATE envios_publicacion
    SET calificacion = :calificacion,
        retroalimentacion = :retroalimentacion
    WHERE id_envio = :id_envio
");

$sql->bindParam(':calificacion', $calificacion);
$sql->bindParam(':retroalimentacion', $retroalimentacion);
$sql->bindParam(':id_envio', $id_envio);

$sql->execute();

header("Location: ../../../admin/calificaciones/tarea_detalle.php?id_publicacion=".$id_publicacion."&msg=calificado");
exit;
