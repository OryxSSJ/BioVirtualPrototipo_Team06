<?php
/**
 * Ubicación del archivo: app/controllers/estudiantes/guardar_entrega.php
 */
include ('../../../app/config.php');
session_start();

// 1. Validar sesión
if (!isset($_SESSION['sesion_email'])) {
    header('Location: ' . APP_URL . '/login');
    exit;
}

// 2. Validar que vengan datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email_sesion = $_SESSION['sesion_email'];
    $id_publicacion = $_POST['id_publicacion'];
    $id_materia = $_POST['id_materia'];
    $comentario = $_POST['comentario'];

    // --- INICIO BLOQUE NUEVO: VERIFICAR FECHA ---
    $query_fecha = $pdo->prepare("SELECT fecha_entrega FROM publicaciones WHERE id_publicacion = :id");
    $query_fecha->bindParam(':id', $id_publicacion);
    $query_fecha->execute();
    $fecha_data = $query_fecha->fetch(PDO::FETCH_ASSOC);

    $fecha_limite = $fecha_data['fecha_entrega'];
    $fecha_actual = date('Y-m-d H:i:s');

    // Si hay fecha límite y la fecha actual es mayor a la límite
    if ($fecha_limite != null && $fecha_actual > $fecha_limite) {
        session_start();
        $_SESSION['mensaje'] = "El plazo de entrega ha vencido. No se aceptan más envíos.";
        $_SESSION['icono'] = "error";
        header('Location: ' . APP_URL . '/estudiantes/ver_tarea.php?id=' . $id_publicacion);
        exit;
    }
    // --- FIN BLOQUE NUEVO ---
    
    // 3. Obtener el ID del estudiante (Seguridad: Usamos el Join correcto)
    $query_id = $pdo->prepare("
        SELECT estudiantes.id_estudiante 
        FROM estudiantes 
        INNER JOIN personas ON estudiantes.persona_id = personas.id_persona
        INNER JOIN usuarios ON personas.usuario_id = usuarios.id_usuario
        WHERE usuarios.email = :email
    ");
    $query_id->bindParam(':email', $email_sesion);
    $query_id->execute();
    $estudiante = $query_id->fetch(PDO::FETCH_ASSOC);
    
    // Si no encuentra al estudiante, detenemos todo
    if(!$estudiante){
        echo "Error: Estudiante no identificado."; exit;
    }
    
    $id_estudiante = $estudiante['id_estudiante'];

    // 4. Procesar el Archivo
    // Verificar si se subió un archivo sin errores
    if (isset($_FILES['archivo_tarea']) && $_FILES['archivo_tarea']['error'] === UPLOAD_ERR_OK) {
        
        $nombre_archivo = $_FILES['archivo_tarea']['name'];
        $ruta_temporal = $_FILES['archivo_tarea']['tmp_name'];
        
        // Generar nombre único: FECHA + ID_ESTUDIANTE + NOMBRE_ORIGINAL
        $nombre_final = date('Y-m-d_H-i-s') . "_Est" . $id_estudiante . "_" . $nombre_archivo;
        
        // Ruta de destino (Asegúrate que esta carpeta exista)
        // Subimos 3 niveles (../../..) para llegar a la raíz, luego entramos a public/
        $carpeta_destino = "../../../public/archivos/tareas/";
        
        // Si la carpeta no existe, intentamos crearla (opcional, pero recomendado)
        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        $ruta_final = $carpeta_destino . $nombre_final;

        // Mover el archivo
        if (move_uploaded_file($ruta_temporal, $ruta_final)) {
            
            // 5. Insertar en Base de Datos
            $sentencia = $pdo->prepare("INSERT INTO envios_publicacion 
                (publicacion_id, estudiante_id, archivo, comentario, fecha_envio, estado) 
                VALUES (:pub_id, :est_id, :archivo, :comentario, NOW(), '1')");

            $sentencia->bindParam(':pub_id', $id_publicacion);
            $sentencia->bindParam(':est_id', $id_estudiante);
            $sentencia->bindParam(':archivo', $nombre_final);
            $sentencia->bindParam(':comentario', $comentario);

            if ($sentencia->execute()) {
                session_start();
                $_SESSION['mensaje'] = "Tarea entregada correctamente";
                $_SESSION['icono'] = "success";
                // Redirigir de vuelta a 'ver_tarea.php' para ver el resultado
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                echo "Error al guardar en la base de datos.";
            }

        } else {
            echo "Error al subir el archivo al servidor. Verifica permisos de carpeta.";
        }

    } else {
        echo "No se ha seleccionado ningún archivo o hubo un error en la subida.";
    }

} else {
    echo "Acceso no permitido via GET.";
}
?>