<?php
// Validar sesión
if (!isset($_SESSION['sesion_email']) || !isset($_GET['id_materia'])) {
    // Redirigir o mostrar error
    die("Error de acceso.");
}

// 1. OBTENER ID ESTUDIANTE Y GRADO (Corregido con doble JOIN)
$email_sesion = $_SESSION['sesion_email'];
$query_id = $pdo->prepare("
    SELECT 
        estudiantes.id_estudiante, 
        estudiantes.id_grado 
    FROM estudiantes 
    INNER JOIN personas ON estudiantes.persona_id = personas.id_persona
    INNER JOIN usuarios ON personas.usuario_id = usuarios.id_usuario
    WHERE usuarios.email = :email
");
$query_id->bindParam(':email', $email_sesion);
$query_id->execute();
$datos_estudiante = $query_id->fetch(PDO::FETCH_ASSOC);

if (!$datos_estudiante) {
    die("Estudiante no encontrado para este usuario.");
}

$id_estudiante_sesion = $datos_estudiante['id_estudiante'];
$id_grado_estudiante = $datos_estudiante['id_grado'];

// 2. OBTENER MATERIA
$id_materia_get = $_GET['id_materia'];
$sql_materia = $pdo->prepare("SELECT nombre_materia FROM materias WHERE id_materia = :id");
$sql_materia->bindParam(':id', $id_materia_get);
$sql_materia->execute();
$materia_info = $sql_materia->fetch(PDO::FETCH_ASSOC);
$nombre_materia = $materia_info['nombre_materia'] ?? 'Materia';

// 3. CONSULTA PUBLICACIONES (Corregida: usa 'grado_id' según tu tabla publicaciones)
$sql_publicaciones = "
    SELECT 
        p.*,
        e.id_envio,
        e.calificacion,
        e.estado as estado_envio
    FROM publicaciones p
    LEFT JOIN envios_publicacion e 
        ON p.id_publicacion = e.publicacion_id 
        AND e.estudiante_id = :id_est
    WHERE p.materia_id = :id_materia 
    AND p.grado_id = :id_grado
    ORDER BY p.fecha_publicacion DESC
";

$query_pubs = $pdo->prepare($sql_publicaciones);
$query_pubs->bindParam(':id_est', $id_estudiante_sesion);
$query_pubs->bindParam(':id_materia', $id_materia_get);
$query_pubs->bindParam(':id_grado', $id_grado_estudiante); // Usamos el dato obtenido en el paso 1
$query_pubs->execute();
$publicaciones = $query_pubs->fetchAll(PDO::FETCH_ASSOC);
?>