<?php
include('../../../app/config.php');
$id_persona = $_POST['id_persona'];
$id_usuario = $_POST['id_usuario'];
$id_docente = $_POST['id_docente'];

$rol_id = $_POST['rol_id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$ci = $_POST['ci'];
$email= $_POST['email'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$celular = $_POST['celular'];
$profesion = $_POST['profesion'];
$direccion = $_POST['direccion'];
$especialidad = $_POST['especialidad'];
$antiguedad = $_POST['antiguedad'];

$pdo -> beginTransaction();
/// Actualizar a Usuarios
$password = password_hash($ci, PASSWORD_DEFAULT);

    $sentencia = $pdo->prepare('UPDATE usuarios 
    SET rol_id=:rol_id,
        nombres=:nombres,
        email=:email,
        password=:password,
        fyh_actualizacion=:fyh_actualizacion
        WHERE id_usuario=:id_usuario');

    $sentencia->bindParam(':rol_id',$rol_id);
    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':email',$email);
    $sentencia->bindParam(':password',$password);
    $sentencia->bindParam('fyh_actualizacion',$fechaHora);
    $sentencia->bindParam('id_usuario',$id_usuario);
    $sentencia->execute();

    /// Actualizar a personas

$sentencia = $pdo->prepare('UPDATE personas SET nombres=:nombres,
                                                       apellidos=:apellidos,
                                                       ci=:ci,
                                                       fecha_nacimiento=:fecha_nacimiento,
                                                       celular=:celular,
                                                       profesion=:profesion,
                                                       direccion=:direccion,
                                                       fyh_actualizacion=:fyh_actualizacion
                                                       WHERE id_persona=:id_persona');
$sentencia->bindParam(':id_persona', $id_persona);
$sentencia->bindParam(':nombres', $nombres);
$sentencia->bindParam(':apellidos', $apellidos);
$sentencia->bindParam(':ci', $ci);
$sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
$sentencia->bindParam(':celular', $celular);
$sentencia->bindParam(':profesion', $profesion);
$sentencia->bindParam(':direccion', $direccion);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);
$sentencia->execute();

///Actualizar a la tabla docentes
$sentencia = $pdo->prepare('UPDATE docentes SET especialidad=:especialidad, 
                                                       antiguedad=:antiguedad, 
                                                       fyh_actualizacion=:fyh_actualizacion
                                                       WHERE id_docente=:id_docente');
$sentencia->bindParam(':id_docente', $id_docente);
$sentencia->bindParam(':especialidad', $especialidad);
$sentencia->bindParam(':antiguedad', $antiguedad);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);



if($sentencia->execute()){
    echo'success';
    $pdo ->commit();
    $_SESSION['mensaje'] = "Docente actualizado de manera correcta";
    $_SESSION['icon'] = "success";
    header('Location:'.APP_URL."/admin/docentes");
}else{
    echo 'error al registrar en la base de datos';
    $pdo->rollBack();
    $_SESSION['mensaje'] = "Error al actualizar los datos";
    $_SESSION['icon'] = "error";
    ?><script>window.history.back()</script><?php
}