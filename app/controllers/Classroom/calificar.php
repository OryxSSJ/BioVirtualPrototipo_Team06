<?php
/**
 * Ubicación: app/controllers/Classroom/calificar.php
 */
include ('../../../app/config.php');

// CORRECCIÓN 1: session_start() solo debe ir una vez al principio
session_start();

// 1. Validar sesión
if (!isset($_SESSION['sesion_email'])) {
    header('Location: ' . APP_URL . '/login');
    exit;
}

// 2. Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_envio = $_POST['id_envio'];
    $id_publicacion = $_POST['id_publicacion']; 
    $calificacion = $_POST['calificacion'];
    $retroalimentacion = $_POST['retroalimentacion'];

    // 3. Actualizar la base de datos
    $sentencia = $pdo->prepare("UPDATE envios_publicacion 
                                SET calificacion = :calificacion, 
                                    retroalimentacion = :retroalimentacion,
                                    estado = '0' 
                                WHERE id_envio = :id_envio");

    $sentencia->bindParam(':calificacion', $calificacion);
    $sentencia->bindParam(':retroalimentacion', $retroalimentacion);
    $sentencia->bindParam(':id_envio', $id_envio);

    if ($sentencia->execute()) {
        
        // CORRECCIÓN 1: Aquí borramos el session_start() que sobraba
        $_SESSION['mensaje'] = "Calificación registrada correctamente";
        $_SESSION['icono'] = "success";

        // CORRECCIÓN 2: Redirección explícita y segura
        // En lugar de usar HTTP_REFERER, construimos la ruta.
        // NOTA: Verifica que la ruta '/admin/classroom/ver_tarea.php' sea la correcta en tu proyecto.
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;

    } else {
        $_SESSION['mensaje'] = "Error al registrar la calificación";
        $_SESSION['icono'] = "error";
        
        // En caso de error, también redirigimos explícitamente
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

} else {
    echo "Acceso no permitido";
}
?>