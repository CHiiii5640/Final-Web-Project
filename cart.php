<?php
session_start();

// 初始化購物車
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 計算總金額
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購物車 - Glitch Mall</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .cart-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: #ffffff;
            color: #111;
            font-weight: bold;
            margin-bottom: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .cart-item h3,
        .cart-item p {
            color: #111;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }
        .cart-total {
            text-align: right;
            font-size: 1.2rem;
            margin: 1rem 0;
        }
        .checkout-btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .checkout-btn:hover {
            background: #45a049;
        }
        .empty-cart {
            text-align: center;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Glitch Mall</h1>
            <div class="nav-links">
                <a href="index.php">首頁</a>
                <a href="cart.php">購物車 (<?php echo count($_SESSION['cart']); ?>)</a>
            </div>
        </nav>
    </header>

    <main class="cart-container">
        <h2>購物車</h2>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <p>購物車是空的</p>
                <a href="index.php" class="checkout-btn">繼續購物</a>
            </div>
        <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="cart-item">
                    <div class="item-info">
                        <h3><?php echo ($item['name']); ?></h3>
                        <p>單價: NT$ <?php echo ($item['price']); ?></p>
                        <p>數量: <?php echo ($item['quantity']); ?></p>
                    </div>
                    <div class="item-total">
                        NT$ <?php echo ($item['price'] * $item['quantity']); ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                總計: NT$ <?php echo ($total); ?>
            </div>

            <a href="checkout.php" class="checkout-btn">前往結帳</a>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Glitch Mall - 惡搞商品專賣店</p>
    </footer>

    <script src="assets/js/easter.js"></script>
</body>
</html> 