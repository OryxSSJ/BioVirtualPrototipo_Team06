<?php
// Recibimos los parámetros que vienen en la URL desde el botón "Tablón"
// Estos datos son enviados desde classroom.php cuando el docente hace clic
// Si no llegan, el script fallará, así que aseguramos que la URL tenga ?id_grado=X&id_docente=Y&id_materia=Z
$id_grado_get   = $_GET['id_grado'];
$id_docente_get = $_GET['id_docente'];
$id_materia_get = $_GET['id_materia'];

try {
    // CONSULTA PARA EL DOCENTE:
    // Filtramos por Docente + Materia + Grado.
    // Esto evita que las tareas de Matemáticas aparezcan en Historia, por ejemplo.
    
    $sql_publicaciones = "SELECT * FROM publicaciones 
                          WHERE docente_id = :docente_id 
                          AND materia_id = :materia_id 
                          AND grado_id = :grado_id 
                          ORDER BY fecha_publicacion DESC";

    $query_publicaciones = $pdo->prepare($sql_publicaciones);
    
    // Vinculamos los 3 parámetros para aislar el contenido de esta clase
    $query_publicaciones->bindParam(':docente_id', $id_docente_get);
    $query_publicaciones->bindParam(':materia_id', $id_materia_get);
    $query_publicaciones->bindParam(':grado_id', $id_grado_get);
    
    $query_publicaciones->execute();
    $publicaciones = $query_publicaciones->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al cargar las publicaciones: " . $e->getMessage();
    $publicaciones = []; // Array vacío para evitar errores en la vista si falla la consulta
}
?>