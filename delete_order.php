<?php
include 'configM.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Не указан ID заказа.");
}

$order_id = intval($_GET['id']);

$stmt = $mysqli->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
if ($stmt->execute()) {
    $stmt->close();
    header("Location: admin.php?section=orders&msg=" . urlencode("Заказ успешно удалён."));
    exit;
} else {
    die("Ошибка удаления заказа: " . $stmt->error);
}
?>
