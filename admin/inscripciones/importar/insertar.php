<?php
include('../../../app/config.php');
$rol_id = $_POST['d1'];
$nombres = $_POST['d2'];
$apellidos = $_POST['d3'];
$ci = $_POST['d4'];
$fecha_nacimiento = $_POST['d5'];
$celular = $_POST['d6'];
$email = $_POST['d7'];
$direccion = $_POST['d8'];
$id_nivel = $_POST['d9'];
$id_grado = $_POST['d10'];
$codigo = $_POST['d11'];
$nombres_apellidos_ppff = $_POST['d12'];
$ci_ppff = $_POST['d13'];
$celular_ppff = $_POST['d14'];
$ocupacion_ppff = $_POST['d15'];
$ref_nombre = $_POST['d16'];
$ref_parentezco = $_POST['d17'];
$ref_celular = $_POST['d18'];
$profesion = "ESTUDIANTE";

if (is_numeric($fecha_nacimiento) && $fecha_nacimiento > 1) {
    // Número de segundos en un día
    $segundos_por_dia = 24 * 60 * 60; 
    
    // PHP usa timestamp UNIX (segundos desde 1/1/1970). Excel usa días desde 1/1/1900.
    // 25569 es el número de días entre 1/1/1900 y 1/1/1970
    $excel_dias_unix = $fecha_nacimiento - 25569;
    
    // Calcular el timestamp UNIX
    $timestamp_unix = $excel_dias_unix * $segundos_por_dia;
    
    // Formatear la fecha a YYYY-MM-DD
    $fecha_nacimiento = date("d-m-Y", $timestamp_unix);
}

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
    $pdo ->commit();
   
}else{
    $pdo->rollBack();
    
}
