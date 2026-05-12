<?php
include('../../../app/config.php');
$id_persona = $_POST['id_persona'];
$id_usuario = $_POST['id_usuario'];
$id_estudiante = $_POST['id_estudiante'];
$id_ppff = $_POST['id_ppff'];

$rol_id = $_POST['rol_id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$ci = $_POST['ci'];
$email= $_POST['email'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$celular = $_POST['celular'];
$profesion = "ESTUDIANTE";
$direccion = $_POST['direccion'];
$id_nivel = $_POST['id_nivel'];
$id_grado = $_POST['id_grado'];
$codigo = $_POST['codigo'];
$nombres_apellidos_ppff = $_POST['nombres_apellidos_ppff'];
$ci_ppff = $_POST['ci_ppff'];
$celular_ppff = $_POST['celular_ppff'];
$ocupacion_ppff = $_POST['ocupacion'];
$ref_nombre = $_POST['ref_nombre'];
$ref_parentezco = $_POST['ref_parentezco'];
$ref_celular = $_POST['ref_celular'];

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
$sentencia->bindParam(':id_persona', $id_persona);
$sentencia->execute();

///Actualizar a la tabla estudiantes
$sentencia = $pdo->prepare('UPDATE estudiantes SET nivel_id=:nivel_id, 
                                                          id_grado=:id_grado, 
                                                          codigo=:codigo,
                                                          fyh_actualizacion=:fyh_actualizacion
                                                          WHERE id_estudiante=:id_estudiante');

$sentencia->bindParam(':nivel_id', $id_nivel);
$sentencia->bindParam(':id_grado', $id_grado);
$sentencia->bindParam(':codigo', $codigo);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);
$sentencia->bindParam(':id_estudiante', $id_estudiante);
$sentencia->execute();

///Actualizar a ppffs
$sentencia = $pdo->prepare('UPDATE ppffs SET nombre_apellidos_ppff=:nombre_apellidos_ppff, 
                                                    ci_ppff=:ci_ppff, 
                                                    celular_ppff=:celular_ppff,
                                                    ocupacion=:ocupacion,
                                                    ref_nombre=:ref_nombre,
                                                    ref_parentezco=:ref_parentezco,
                                                    ref_celular=:ref_celular,
                                                    fyh_actualizacion=:fyh_actualizacion
                                                    WHERE id_ppff=:id_ppff');
$sentencia->bindParam(':nombre_apellidos_ppff', $nombres_apellidos_ppff);
$sentencia->bindParam(':ci_ppff', $ci_ppff);
$sentencia->bindParam(':ocupacion', $ocupacion_ppff);
$sentencia->bindParam(':celular_ppff', $celular_ppff);
$sentencia->bindParam(':ref_nombre', $ref_nombre);
$sentencia->bindParam(':ref_parentezco', $ref_parentezco);
$sentencia->bindParam(':ref_celular', $ref_celular);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);
$sentencia->bindParam(':id_ppff', $id_ppff);

if($sentencia->execute()){
    echo'success';
    $pdo ->commit();
    $_SESSION['mensaje'] = "Estudiante actualizado de manera correcta";
    $_SESSION['icon'] = "success";
    header('Location:'.APP_URL."/admin/estudiantes");
}else{
    echo 'error al registrar en la base de datos';
    $pdo->rollBack();
    $_SESSION['mensaje'] = "Error al actualizar los datos";
    $_SESSION['icon'] = "error";
    ?><script>window.history.back()</script><?php
}