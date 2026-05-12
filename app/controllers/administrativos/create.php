<?php
include('../../../app/config.php');

$rol_id = $_POST['rol_id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$ci = $_POST['ci'];
$email= $_POST['email'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$celular = $_POST['celular'];
$profesion = $_POST['profesion'];
$direccion = $_POST['direccion'];

$pdo -> beginTransaction();
/// Insertar a Usuarios
$password = password_hash($ci, PASSWORD_DEFAULT);

    $sentencia = $pdo->prepare('INSERT INTO usuarios
( rol_id,nombres,email,password, fyh_creacion, estado)
VALUES ( :rol_id,:nombres,:email,:password,:fyh_creacion,:estado)');

    $sentencia->bindParam(':rol_id',$rol_id);
    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':email',$email);
    $sentencia->bindParam(':password',$password);
    $sentencia->bindParam('fyh_creacion',$fechaHora);
    $sentencia->bindParam('estado',$estado_de_registro);

    $sentencia->execute();
    $id_usuario = $pdo->lastInsertId();

    /// Insertar a personas

$sentencia = $pdo->prepare('INSERT INTO personas (usuario_id,nombres,apellidos,ci,fecha_nacimiento,celular,profesion,direccion,fyh_creacion,estado)
VALUES ( :usuario_id,:nombres,:apellidos,:ci,:fecha_nacimiento,:celular,:profesion,:direccion,:fyh_creacion,:estado)');

$sentencia->bindParam(':usuario_id', $id_usuario);
$sentencia->bindParam(':nombres', $nombres);
$sentencia->bindParam(':apellidos', $apellidos);
$sentencia->bindParam(':ci', $ci);
$sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
$sentencia->bindParam(':celular', $celular);
$sentencia->bindParam(':profesion', $profesion);
$sentencia->bindParam(':direccion', $direccion);
$sentencia->bindParam('fyh_creacion', $fechaHora);
$sentencia->bindParam('estado', $estado_de_registro);
$sentencia->execute();
$id_persona = $pdo->lastInsertId();

///Insertar a la tabla administrativos
$sentencia = $pdo->prepare('INSERT INTO administrativos (persona_id,fyh_creacion,estado)
VALUES ( :persona_id,:fyh_creacion,:estado)');

$sentencia->bindParam(':persona_id', $id_persona);
$sentencia->bindParam('fyh_creacion', $fechaHora);
$sentencia->bindParam('estado', $estado_de_registro);



if($sentencia->execute()){
    echo'success';
    $pdo ->commit();
    $_SESSION['mensaje'] = "Registrado de manera correcta";
    $_SESSION['icon'] = "success";
    header('Location:'.APP_URL."/admin/administrativos");
}else{
    echo 'error al registrar en la base de datos';
    $pdo->rollBack();
    $_SESSION['mensaje'] = "Error al registrar";
    $_SESSION['icon'] = "error";
    ?><script>window.history.back()</script><?php
}

