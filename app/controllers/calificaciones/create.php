<?php
include('../../../app/config.php');
$id_docente = $_GET['id_docente'];
$id_estudiante = $_GET['id_estudiante'];
$id_materia = $_GET['id_materia'];
$parcial1 = $_GET['parcial1'];
$parcial2 = $_GET['parcial2'];
$parcial3 = $_GET['parcial3'];

//Parcial 1
$sql = "SELECT * FROM calificaciones WHERE docente_id ='$id_docente' and estudiante_id = '$id_estudiante' and materia_id = '$id_materia'";
$query = $pdo->prepare($sql);
$query->execute();
$parcial = $query->fetch(PDO::FETCH_ASSOC);

if($parcial){
  echo "si existe registro";
  $id_calificacion = $parcial['id_calificacion'];
  $sentencia = $pdo->prepare('UPDATE calificaciones
                                     SET parcial1=:parcial1,
                                         parcial2=:parcial2,
                                         parcial3=:parcial3,  
                                         fyh_actualizacion=:fyh_actualizacion
                                    WHERE id_calificacion=:id_calificacion ');
$sentencia->bindParam(':parcial1',$parcial1);
$sentencia->bindParam(':parcial2',$parcial2);
$sentencia->bindParam(':parcial3',$parcial3);

$sentencia->bindParam('fyh_actualizacion',$fechaHora);
$sentencia->bindParam('id_calificacion',$id_calificacion);
$sentencia->execute();
}else{
  echo "No existe registro";
$sentencia = $pdo->prepare('INSERT INTO calificaciones
                                   (docente_id, estudiante_id, materia_id, parcial1, parcial2, parcial3,  fyh_creacion, estado)
VALUES ( :docente_id,:estudiante_id,:materia_id, :parcial1, :parcial2, :parcial3, :fyh_creacion,:estado)');

$sentencia->bindParam(':docente_id',$id_docente);
$sentencia->bindParam(':estudiante_id',$id_estudiante);
$sentencia->bindParam(':materia_id',$id_materia);
$sentencia->bindParam(':parcial1',$parcial1);
$sentencia->bindParam(':parcial2',$parcial2);
$sentencia->bindParam(':parcial3',$parcial3);
$sentencia->bindParam('fyh_creacion',$fechaHora);
$sentencia->bindParam('estado',$estado_de_registro);
$sentencia->execute();

}

//Parcial 2


//Parcial 3