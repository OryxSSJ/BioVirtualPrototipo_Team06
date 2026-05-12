<?php
include('../../../app/config.php');

// 1. Validar que los datos obligatorios lleguen
if (!isset($_POST['grado_id']) || !isset($_POST['titulo'])) {
    echo "Error: Faltan datos obligatorios.";
    exit;
}

$grado_id = $_POST['grado_id'];
$docente_id = $_POST['docente_id'];
$materia_id = $_POST['materia_id'];
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];
$tipo = $_POST['tipo'];

// 2. Manejo correcto de la fecha de entrega
// Si el campo viene vacío (string vacío ""), lo convertimos a NULL para que SQL no falle
$fecha_entrega = !empty($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : NULL;

$archivo = NULL;
if (!empty($_FILES['archivo']['name'])) {
    // Es buena práctica verificar errores de subida
    if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $ruta = '../../../public/classroom/';
        
        // Asegurarse de que el directorio existe
        if (!is_dir($ruta)) {
            mkdir($ruta, 0777, true);
        }

        // Limpiar el nombre del archivo para evitar caracteres extraños
        $nombreOriginal = basename($_FILES['archivo']['name']);
        $nombreArchivo = date("YmdHis") . "_" . $nombreOriginal;
        
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta . $nombreArchivo)) {
            $archivo = $nombreArchivo;
        } else {
            // Manejo de error si no se pudo mover el archivo
            echo "Error al subir el archivo al servidor.";
            exit;
        }
    }
}

try {
    $sql = "INSERT INTO publicaciones (
                docente_id, 
                materia_id, 
                grado_id, 
                titulo, 
                contenido, 
                archivo, 
                tipo, 
                fecha_entrega
            ) VALUES (
                :docente_id, 
                :materia_id, 
                :grado_id, 
                :titulo, 
                :contenido, 
                :archivo, 
                :tipo, 
                :fecha_entrega
            )";

    $query = $pdo->prepare($sql);
    $query->bindParam(':docente_id', $docente_id);
    $query->bindParam(':materia_id', $materia_id);
    $query->bindParam(':grado_id', $grado_id);
    $query->bindParam(':titulo', $titulo);
    $query->bindParam(':contenido', $contenido);
    $query->bindParam(':archivo', $archivo);
    $query->bindParam(':tipo', $tipo);
    
    // IMPORTANTE: Especificar que puede ser NULL si es necesario
    if ($fecha_entrega === NULL) {
        $query->bindValue(':fecha_entrega', NULL, PDO::PARAM_NULL);
    } else {
        $query->bindParam(':fecha_entrega', $fecha_entrega);
    }

    if ($query->execute()) {
        // Redirección exitosa
        header("Location: ../../../admin/calificaciones/classroom.php?id_grado=$grado_id&id_docente=$docente_id&id_materia=$materia_id&msg=ok");
        exit;
    } else {
        echo "Error al guardar en la base de datos.";
        print_r($query->errorInfo()); // Útil para depurar
    }

} catch (PDOException $e) {
    echo "Error Excepción: " . $e->getMessage();
}