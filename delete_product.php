<?php
include 'configM.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}


if (!isset($_GET['id'])) {
    die("Не указан ID товара.");
}

$product_id = intval($_GET['id']);

$stmt = $mysqli->prepare("DELETE FROM products WHERE id = ?");
if (!$stmt) {
    die("Ошибка подготовки запроса: " . $mysqli->error);
}
$stmt->bind_param("i", $product_id);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: admin.php?section=products&msg=" . urlencode("Товар успешно удалён."));
    exit;
} else {
    die("Ошибка удаления товара: " . $stmt->error);
}
?>
