<?php
// Validar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['sesion_email'])) {
    echo "No hay sesión iniciada.";
    exit;
}

$email_sesion = $_SESSION['sesion_email'];

// 1. Consultar el ID y el GRADO del estudiante
// CORRECCIÓN: Hacemos el triple JOIN (Usuario -> Persona -> Estudiante)
// Porque 'estudiantes' no tiene 'usuario_id', lo tiene 'personas'.
$sql_estudiante = "SELECT 
                    est.id_estudiante, 
                    est.id_grado, 
                    g.curso, 
                    g.paralelo 
                   FROM usuarios u 
                   INNER JOIN personas p ON u.id_usuario = p.usuario_id
                   INNER JOIN estudiantes est ON p.id_persona = est.persona_id
                   INNER JOIN grados g ON g.id_grado = est.id_grado
                   WHERE u.email = :email";

try {
    $query_est = $pdo->prepare($sql_estudiante);
    $query_est->bindParam(':email', $email_sesion);
    $query_est->execute();
    $estudiante_datos = $query_est->fetch(PDO::FETCH_ASSOC);

    // Validación por si el estudiante no tiene grado asignado o no existe
    if (!$estudiante_datos) {
        $materias = [];
        $nombre_grado = "Sin grado asignado";
    } else {
        $id_grado_estudiante = $estudiante_datos['id_grado'];
        $nombre_grado = $estudiante_datos['curso'] . " " . $estudiante_datos['paralelo'];

        // 2. Obtener las materias asignadas a ese grado
        // IMPORTANTE: En tu BD, la tabla 'materias' no tiene la columna 'grado_id'.
        // Pero la tabla 'asignaciones' sí relaciona un grado con una materia.
        // Por eso hacemos JOIN con 'asignaciones'.
        
        $sql_materias = "SELECT DISTINCT m.* FROM asignaciones a
                         INNER JOIN materias m ON m.id_materia = a.materia_id
                         WHERE a.grado_id = :id_grado 
                         AND a.estado = '1'";
        
        $query_mat = $pdo->prepare($sql_materias);
        $query_mat->bindParam(':id_grado', $id_grado_estudiante);
        $query_mat->execute();
        $materias = $query_mat->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error al cargar materias: " . $e->getMessage() . "</div>";
    $materias = []; 
}
?>