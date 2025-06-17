<?php
include 'configM.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Магазин цветов</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../cve/mycss/styleS.css" rel="stylesheet">
  <style>
    .mobile-header { display: none; }

    .burger-icon {
      display: inline-block;
      width: 24px;
      height: 18px;
      position: relative;
    }

    .burger-icon span {
      background: #333;
      position: absolute;
      height: 3px;
      width: 100%;
      left: 0;
      transition: 0.3s;
    }

    .burger-icon span:nth-child(1) { top: 0; }
    .burger-icon span:nth-child(2) { top: 7px; }
    .burger-icon span:nth-child(3) { top: 14px; }

    @media (max-width: 768px) {
      .desktop-header { display: none; }
      .mobile-header { display: block; }
    }
  </style>
</head>
<body>

<header class="desktop-header">
  <div class="top-header">
    <div class="container d-flex justify-content-between">
      <div>
        <a href="about.php">О нас</a><span>|</span>
        <a href="payment.php">Оплата</a><span>|</span>
        <a href="delivery.php">Доставка</a><span>|</span>
        <a href="guarantees.php">Гарантии</a><span>|</span>
        <a href="contacts.php">Контакты</a>
      </div>
      <div>
        <span>+7 (123) 456-78-90</span><span>|</span>
        <a href="https://web.telegram.org/">Телеграм</a><span>|</span>
        <a href="http://vk.ru">ВК</a><span>|</span>
        <a href="https://ok.ru">Одноклассники</a>
      </div>
    </div>
  </div>

  <div class="header-middle">
    <div class="container">
      <div class="logo">
        <a href="index.php"><img src="img/logo.png" alt="Логотип"></a>
      </div>
      <div class="city-info">
        <p>Барнаул</p>
        <p>Доставка с 9:00 до 21:00</p>
      </div>
      <div class="search flex-grow-1 mx-4">
        <input type="text" class="form-control" placeholder="Поиск...">
      </div>
      <div class="icons">
        <a href="basket.php"><img src="img/basket.png" alt="Корзина"><div>Корзина</div></a>
        <a href="orders.php"><img src="img/orders.png" alt="Заказы"><div>Заказы</div></a>
        <?php if (!isset($_SESSION['user_id'])): ?>
          <a href="autorization.php"><img src="img/personal.png" alt="Вход"><div>Вход</div></a>
        <?php else: ?>
          <a href="<?= ($_SESSION['role'] === 'admin') ? 'admin.php' : 'profile.php' ?>"><img src="img/personal.png" alt="Кабинет"><div>Ваш кабинет</div></a>
          <a href="logout.php"><img src="img/exit.png" alt="Выход"><div>Выход</div></a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="header-bottom">
    <div class="container">
      <nav>
        <ul>
          <li><a href="index.php">Главная</a></li>
          <li><a href="catalog.php#Цветы">Цветы</a>
            <ul>
              <li><a href="catalog.php#Цветы-на-каждый-день">Цветы на каждый день</a></li>
              <li><a href="catalog.php#Комнатные-растения">Комнатные растения</a></li>
            </ul>
          </li>
          <li><a href="catalog.php#Букеты">Букеты</a>
            <ul>
              <li><a href="catalog.php#Сборные-букеты">Сборные букеты</a></li>
            </ul>
          </li>
          <li><a href="catalog.php#Композиции">Композиции</a>
          </li>
          <li><a href="catalog.php#Праздники">Праздники</a>
            <ul>
              <li><a href="catalog.php#8-марта">8 марта</a></li>
              <li><a href="catalog.php#1-сентября">1 сентября</a></li>
              <li><a href="catalog.php#День-рождения">День рождения</a></li>
            </ul>
          </li>
          <li><a href="catalog.php#Всё-для-растений">Всё для растений</a>
            <ul>
              <li><a href="catalog.php#Грунт">Грунт</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>

<header class="mobile-header">
  <div class="bg-light text-center py-1 small border-bottom">
    +7 (123) 456-78-90
  </div>

  <div class="text-center py-2">
    <a href="index.php"><img src="img/logo.png" alt="Логотип" style="width: 80px;"></a>
    <div class="small text-muted">Барнаул, доставка с 9:00 до 21:00</div>
  </div>

  <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top border-bottom">
    <div class="d-flex gap-3">
      <a href="basket.php"><img src="img/basket.png" style="width: 24px;"></a>
      <a href="orders.php"><img src="img/orders.png" style="width: 24px;"></a>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="autorization.php"><img src="img/personal.png" style="width: 24px;"></a>
      <?php else: ?>
        <a href="<?= ($_SESSION['role'] === 'admin') ? 'admin.php' : 'profile.php' ?>"><img src="img/personal.png" style="width: 24px;"></a>
        <a href="logout.php"><img src="img/exit.png" style="width: 24px;"></a>
      <?php endif; ?>
    </div>

    <div class="dropdown">
      <button class="btn p-0 border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="burger-icon">
          <span></span><span></span><span></span>
        </div>
      </button>
      <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="index.php">Главная</a></li>
        <li><a class="dropdown-item" href="catalog.php#Цветы">Цветы</a></li>
        <li><a class="dropdown-item" href="catalog.php#Букеты">Букеты</a></li>
        <li><a class="dropdown-item" href="catalog.php#Композиции">Композиции</a></li>
        <li><a class="dropdown-item" href="catalog.php#Праздники">Праздники</a></li>
        <li><a class="dropdown-item" href="catalog.php#Всё-для-растени">Всё для растений</a></li>
      </ul>
    </div>
  </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
