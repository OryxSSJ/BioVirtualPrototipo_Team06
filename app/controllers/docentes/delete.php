<?php

include('../../../app/config.php');

 $id_docente = $_POST['id_docente'];

 $sentencia = $pdo->prepare("DELETE FROM docentes where id_docente=:id_docente ");
 $sentencia->bindParam('id_docente',$id_docente);

 try{
  if($sentencia->execute()){
    session_start();
  $_SESSION['mensaje']="Se elimino al administrativo de manera correcta";
  $_SESSION['icono'] ="success";
  header('Location:'.APP_URL."/admin/docentes");
  }else{
    session_start();
  $_SESSION['mensaje']="Erro al eliminar al administrativo de la base de datos";
  $_SESSION['icono'] ="error";
  header('Location:'.APP_URL."/admin/docentes");
  }
 }catch(Exception $e){
  session_start();
  $_SESSION['mensaje']= "Error al eliminar, ya existe en otras tablas";
  $_SESSION['icono'] ="error";
  header('Location:'.APP_URL."/admin/docentes");
 }