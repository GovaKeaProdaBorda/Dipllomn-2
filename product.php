<?php
include 'header.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Товар не найден!</div></div>";
    exit;
}

// Получаем товар
$stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Товар не найден!</div></div>";
    exit;
}
?>
<main class="container my-5">
  <div class="row">
    <div class="col-md-6">
      <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="col-md-6">
      <h1 class="mb-3"><?= htmlspecialchars($product['name']) ?></h1>
      <p class="text-muted"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      <h4 class="text-primary mt-4">Цена: <?= number_format($product['price'], 2, ',', ' ') ?> руб.</h4>
      <p class="mt-2"><strong>Категория:</strong> <?= htmlspecialchars($product['category']) ?></p>

      <!-- Форма добавления в корзину -->
      <form action="add_to_basket.php" method="POST" class="d-flex flex-wrap align-items-center mt-4 gap-2">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <label for="quantity" class="me-2">Количество:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control w-auto">
        <button type="submit" class="btn btn-outline-success">Добавить в корзину</button>
      </form>

    </div>
  </div>

  <!-- Похожие товары -->
  <div class="mt-5">
    <h2>Похожие товары</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-3">
      <?php
      $related_stmt = $mysqli->prepare("SELECT * FROM products WHERE category = ? AND id != ? LIMIT 4");
      $related_stmt->bind_param("si", $product['category'], $product_id);
      $related_stmt->execute();
      $related_result = $related_stmt->get_result();

      while ($related_product = $related_result->fetch_assoc()):
      ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="<?= htmlspecialchars($related_product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($related_product['name']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($related_product['name']) ?></h5>
            <p class="card-text"><?= number_format($related_product['price'], 2, ',', ' ') ?> руб.</p>
          </div>
          <div class="card-footer bg-transparent border-top-0">
            <a href="product.php?id=<?= $related_product['id'] ?>" class="btn btn-outline-primary w-100">Смотреть</a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>
