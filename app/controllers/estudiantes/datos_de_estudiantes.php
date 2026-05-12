<?php

$sql_estudiantes = "SELECT * FROM usuarios as usu INNER JOIN roles as rol ON rol.id_rol = usu.rol_id
INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
INNER JOIN estudiantes as est ON est.persona_id = per.id_persona 
INNER JOIN niveles as niv ON niv.id_nivel = est.nivel_id
INNER JOIN grados as gra ON gra.id_grado = est.id_grado
INNER JOIN ppffs as ppf ON ppf.estudiante_id = est.id_estudiante  where est.estado='1' and est.id_estudiante = '$id_estudiante'";
$query_estudiantes = $pdo->prepare($sql_estudiantes);
$query_estudiantes->execute();
$estudiantes = $query_estudiantes->fetchAll(PDO::FETCH_ASSOC);


foreach($estudiantes as $estudiante){
$id_usuario = $estudiante["id_usuario"];
$id_persona = $estudiante["id_persona"];
$id_estudiante = $estudiante["id_estudiante"];
$id_ppff = $estudiante["id_ppff"];
$rol_id = $estudiante['rol_id'];
$nombre_rol = $estudiante['nombre_rol'];
$nombres = $estudiante['nombres'];
$apellidos = $estudiante['apellidos'];
$ci = $estudiante['ci'];
$fecha_nacimiento = $estudiante['fecha_nacimiento'];
$celular = $estudiante['celular'];
$email = $estudiante['email'];
$direccion = $estudiante['direccion'];
$id_nivel = $estudiante['id_nivel'];
$nivel = $estudiante['nivel'];
$turno = $estudiante['turno'];
$id_grado = $estudiante['id_grado'];
$curso = $estudiante['curso'];
$paralelo = $estudiante['paralelo'];
$codigo = $estudiante['codigo'];
$nombres_apellidos_ppff = $estudiante['nombre_apellidos_ppff'];
$ci_ppff = $estudiante['ci_ppff'];
$celular_ppff = $estudiante['celular_ppff'];
$ocupacion_ppff = $estudiante['ocupacion'];
$ref_nombre = $estudiante['ref_nombre'];
$ref_parentezco = $estudiante['ref_parentezco'];
$ref_celular = $estudiante['ref_celular'];
$estado = $estudiante['estado'];
}