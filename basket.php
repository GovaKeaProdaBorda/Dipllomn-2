<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: autorization.php");
    exit;
}

include 'header.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT b.id AS basket_id, b.quantity, p.* 
        FROM basket b 
        JOIN products p ON b.product_id = p.id 
        WHERE b.user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$basket_items = [];
while ($row = $result->fetch_assoc()) {
    $basket_items[] = $row;
}
$stmt->close();
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Ваша корзина</h2>
    
    <?php if (empty($basket_items)): ?>
        <p class="text-center">Ваша корзина пуста.</p>
    <?php else: ?>
        <form method="POST" action="update_basket.php">
    <div class="table-responsive d-none d-md-block">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Товар</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Итого</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($basket_items as $item): ?>
                    <?php 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-fluid" style="max-width: 100px;">
                        </td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> руб.</td>
                        <td>
                            <input type="hidden" name="basket_ids[]" value="<?= $item['basket_id'] ?>">
                            <input type="number" name="quantities[]" class="form-control" value="<?= $item['quantity'] ?>" min="1"  max="99">
                        </td>
                        <td><?= number_format($subtotal, 2) ?> руб.</td>
                        <td>
                            <a href="delete_basket.php?id=<?= $item['basket_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить товар?');">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">Итого:</td>
                    <td colspan="2" class="text-start"><?= number_format($total, 2) ?> руб.</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-md-none">
        <?php $total = 0; ?>
        <?php foreach ($basket_items as $item): ?>
            <?php 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-thumbnail me-3" style="width: 100px;">
                        <div>
                            <h6><?= htmlspecialchars($item['name']) ?></h6>
                            <p class="mb-1">Цена: <?= number_format($item['price'], 2) ?> руб.</p>
                            <p class="mb-1">Итого: <?= number_format($subtotal, 2) ?> руб.</p>
                            <input type="hidden" name="basket_ids[]" value="<?= $item['basket_id'] ?>">
                            <input type="number" name="quantities[]" class="form-control mb-2" value="<?= $item['quantity'] ?>" min="1"  max="99">
                            <a href="delete_basket.php?id=<?= $item['basket_id'] ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Удалить товар?');">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="text-end fw-bold mb-3">
            Итого: <?= number_format($total, 2) ?> руб.
        </div>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mt-4">
        <button type="submit" class="btn btn-secondary w-100 w-md-auto">Обновить корзину</button>
        <a href="checkout.php" class="btn btn-primary w-100 w-md-auto">Оформить заказ</a>
    </div>
</form>

    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
