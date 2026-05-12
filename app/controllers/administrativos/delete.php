<?php
 include('../../../app/config.php');

 $id_administrativo = $_POST['id_administrativo'];

 $sentencia = $pdo->prepare("DELETE FROM administrativos where id_administrativo=:id_administrativo ");
 $sentencia->bindParam('id_administrativo',$id_administrativo);

 try{
  if($sentencia->execute()){
    session_start();
  $_SESSION['mensaje']="Se elimino al administrativo de manera correcta";
  $_SESSION['icono'] ="success";
  header('Location:'.APP_URL."/admin/administrativos");
  }else{
    session_start();
  $_SESSION['mensaje']="Erro al eliminar al administrativo de la base de datos";
  $_SESSION['icono'] ="error";
  header('Location:'.APP_URL."/admin/administrativos");
  }
 }catch(Exception $e){
  session_start();
  $_SESSION['mensaje']= "Error al eliminar, ya existe en otras tablas";
  $_SESSION['icono'] ="error";
  header('Location:'.APP_URL."/admin/administrativos");
 }