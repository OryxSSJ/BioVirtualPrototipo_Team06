<?php
include('../../../app/config.php');
$rol_id = $_POST['rol_id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$ci = $_POST['ci'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$id_nivel = $_POST['id_nivel'];
$id_grado = $_POST['id_grado'];
$codigo = $_POST['codigo'];
$nombres_apellidos_ppff = $_POST['nombre_apellidos_ppff'];
$ci_ppff = $_POST['ci_ppff'];
$celular_ppff = $_POST['celular_ppff'];
$ocupacion_ppff = $_POST['ocupacion'];
$ref_nombre = $_POST['ref_nombre'];
$ref_parentezco = $_POST['ref_parentezco'];
$ref_celular = $_POST['ref_celular'];
$profesion = "ESTUDIANTE";

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

///Insertar a la tabla ESTUDIANTES  
$sentencia = $pdo->prepare('INSERT INTO estudiantes (persona_id,nivel_id,id_grado, codigo,  fyh_creacion,estado)
VALUES ( :persona_id,:nivel_id,:id_grado, :codigo,:fyh_creacion,:estado)');

$sentencia->bindParam(':persona_id', $id_persona);
$sentencia->bindParam(':nivel_id', $id_nivel);
$sentencia->bindParam(':id_grado', $id_grado);
$sentencia->bindParam(':codigo', $codigo);
$sentencia->bindParam('fyh_creacion', $fechaHora);
$sentencia->bindParam('estado', $estado_de_registro);
$sentencia->execute();

$id_estudiante = $pdo->lastInsertId();


///Insertar a la tabla PPFF  
$sentencia = $pdo->prepare('INSERT INTO ppffs (estudiante_id,nombre_apellidos_ppff,ci_ppff,celular_ppff,ocupacion,ref_nombre,ref_parentezco,ref_celular, fyh_creacion,estado)
VALUES ( :estudiante_id,:nombre_apellidos_ppff,:ci_ppff, :celular_ppff,:ocupacion,:ref_nombre,:ref_parentezco,:ref_celular,:fyh_creacion,:estado)');

$sentencia->bindParam(':estudiante_id', $id_estudiante);
$sentencia->bindParam(':nombre_apellidos_ppff', $nombres_apellidos_ppff);
$sentencia->bindParam(':ci_ppff', $ci_ppff);
$sentencia->bindParam(':celular_ppff', $celular_ppff);
$sentencia->bindParam(':ocupacion', $ocupacion_ppff);
$sentencia->bindParam(':ref_nombre', $ref_nombre);
$sentencia->bindParam(':ref_parentezco', $ref_parentezco);
$sentencia->bindParam(':ref_celular', $ref_celular);
$sentencia->bindParam('fyh_creacion', $fechaHora);
$sentencia->bindParam('estado', $estado_de_registro);

if($sentencia->execute()){
    echo'success';
    $pdo ->commit();
    $_SESSION['mensaje'] = "Estudiante registrado de manera correcta";
    $_SESSION['icon'] = "success";
    header('Location:'.APP_URL."/admin/estudiantes");
}else{
    echo 'error al registrar en la base de datos';
    $pdo->rollBack();
    $_SESSION['mensaje'] = "Error al registrar";
    $_SESSION['icon'] = "error";
    ?><script>window.history.back()</script><?php
}
