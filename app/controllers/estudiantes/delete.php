<?php
include ('../../../app/config.php');

$id_estudiante = $_POST['id_estudiantes']; // ID del estudiante a eliminar

try {
    // 1. Iniciar Transacción
    $pdo->beginTransaction();

    // =========================================================
    // 2. OBTENER IDs DE TABLAS PADRE (Para el borrado final)
    // =========================================================
    // Necesitas el id_persona y el id_usuario vinculado antes de borrar el estudiante.
    $stmt_ids = $pdo->prepare("
        SELECT 
            e.persona_id, 
            p.usuario_id 
        FROM estudiantes e 
        JOIN personas p ON e.persona_id = p.id_persona 
        WHERE e.id_estudiante = :id_estudiante
    ");
    $stmt_ids->bindParam(':id_estudiante', $id_estudiante);
    $stmt_ids->execute();
    $datos = $stmt_ids->fetch(PDO::FETCH_ASSOC);

    if (!$datos) {
        throw new Exception("Estudiante no encontrado.");
    }

    $id_persona = $datos['persona_id'];
    $id_usuario = $datos['usuario_id'];


    // =========================================================
    // 3. ELIMINACIÓN EN ORDEN INVERSO (CASCADA MANUAL)
    // =========================================================
    
    // a) Eliminar los Padres/Apoderados (PPFFs) vinculados al estudiante (Tabla más hija)
    $sentencia_ppffs = $pdo->prepare("DELETE FROM ppffs WHERE estudiante_id = :id_estudiante");
    $sentencia_ppffs->bindParam(':id_estudiante', $id_estudiante);
    $sentencia_ppffs->execute();

    // b) Eliminar el Estudiante (Tabla hija de 'personas')
    $sentencia_estudiante = $pdo->prepare("DELETE FROM estudiantes WHERE id_estudiante = :id_estudiante");
    $sentencia_estudiante->bindParam(':id_estudiante', $id_estudiante);
    $sentencia_estudiante->execute();

    // c) Eliminar la Persona vinculada al estudiante
    $sentencia_persona = $pdo->prepare("DELETE FROM personas WHERE id_persona = :id_persona");
    $sentencia_persona->bindParam(':id_persona', $id_persona);
    $sentencia_persona->execute();

    // d) Eliminar el Usuario (Tabla padre de 'personas')
    $sentencia_usuario = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
    $sentencia_usuario->bindParam(':id_usuario', $id_usuario);
    $sentencia_usuario->execute();
    
    // 4. Confirmar Transacción
    $pdo->commit();

    // Redirección de éxito
    session_start();
    $_SESSION['mensaje'] = "Se eliminó el estudiante y todos sus datos vinculados correctamente.";
    $_SESSION['icono'] = "success";
    header('Location:'.APP_URL."/admin/estudiantes");

} catch (PDOException $e) {
    // 5. Revertir si hay un fallo de DB
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    // Redirección de error
    session_start();
    $_SESSION['mensaje'] = "Error de base de datos: " . $e->getMessage() . ". Comuníquese con el administrador.";
    $_SESSION['icono'] = "error";
    header('Location:'.APP_URL."/admin/estudiantes");

} catch (Exception $e) {
    // 6. Revertir si hay un fallo lógico (ej. estudiante no encontrado)
     if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    session_start();
    $_SESSION['mensaje'] = "Error lógico: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    header('Location:'.APP_URL."/admin/estudiantes");
}

?>