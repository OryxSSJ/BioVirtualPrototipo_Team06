<?php
include('../../config.php');
session_start();

// VALIDAR QUE VIENE POR POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . APP_URL . '/admin');
    exit;
}

// VALIDAR QUE EXISTE EL ID
if (!isset($_POST['id_publicacion'])) {
    $_SESSION['mensaje'] = "Error: No se recibió la publicación a eliminar.";
    $_SESSION['icono'] = "error";
    header('Location: ' . APP_URL . '/admin');
    exit;
}

$id_publicacion = $_POST['id_publicacion'];

// Verificar que la publicación existe
$sql = "SELECT * FROM publicaciones WHERE id_publicacion = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id_publicacion);
$stmt->execute();
$publicacion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$publicacion) {
    $_SESSION['mensaje'] = "Error: La publicación no existe.";
    $_SESSION['icono'] = "error";
    header('Location: ' . APP_URL . '/admin');
    exit;
}

// ELIMINAR PUBLICACIÓN
$delete = $pdo->prepare("DELETE FROM publicaciones WHERE id_publicacion = :id");
$delete->bindParam(':id', $id_publicacion);

if ($delete->execute()) {

    $_SESSION['mensaje'] = "Publicación eliminada correctamente.";
    $_SESSION['icono'] = "success";

} else {

    $_SESSION['mensaje'] = "Error al eliminar la publicación.";
    $_SESSION['icono'] = "error";
}

// REDIRECCIÓN (volver al tablón)
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
