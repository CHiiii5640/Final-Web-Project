<?php
session_start();

// 獲取訂單 ID
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

// 讀取訂單數據
$order_file = 'data/orders/order_' . $order_id . '.json';
$order = json_decode(file_get_contents($order_file), true);

// 如果訂單不存在或無效，重定向到首頁
if (!$order) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂單成功 - Glitch Mall</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .success-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            text-align: center;
        }
        .success-message {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            color: #111;
            font-weight: bold;
        }
        .order-details {
            background: #f9f9f9;
            padding: 1rem;
            border-radius: 4px;
            text-align: left;
            color: #111;
            font-weight: bold;
        }
        .order-details p,
        .order-details h3,
        .order-details h4,
        .order-details label,
        .order-details span {
            color: #111 !important;
            font-weight: bold;
        }
        .continue-shopping {
            display: inline-block;
            padding: 1rem 2rem;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .continue-shopping:hover {
            background: #45a049;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-weight: bold;
            color: #111;
            text-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }
        .cart-total {
            font-size: 1.1rem;
            text-align: right;
            margin-top: 1rem;
            font-weight: bold;
            color: #111;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Glitch Mall</h1>
            <div class="nav-links">
                <a href="index.php">首頁</a>
                <a href="cart.php">購物車 (0)</a>
            </div>
        </nav>
    </header>

    <main class="success-container">
        <div class="success-message">
            <h2>🎉 訂單成功！</h2>
            <p>感謝您的購買！您的訂單已經成功建立。</p>
            <p>訂單編號：<?php echo htmlspecialchars($order_id); ?></p>
        </div>

        <div class="order-details">
            <h3>訂單詳情</h3>
            <p>訂購時間：<?php echo htmlspecialchars($order['timestamp']); ?></p>
            <p>收件人：<?php echo htmlspecialchars($order['customer_info']['name']); ?></p>
            <p>電子郵件：<?php echo htmlspecialchars($order['customer_info']['email']); ?></p>
            <p>收件地址：<?php echo htmlspecialchars($order['customer_info']['address']); ?></p>
            
            <h4>訂購商品</h4>
            <?php foreach ($order['items'] as $item): ?>
                <div class="cart-item">
                    <span><?php echo htmlspecialchars($item['name']); ?></span>
                    <span>x<?php echo htmlspecialchars($item['quantity']); ?></span>
                    <span>NT$ <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></span>
                </div>
            <?php endforeach; ?>
            
            <div class="cart-total">
                總計: NT$ <?php echo htmlspecialchars($order['total']); ?>
            </div>
        </div>

        <a href="index.php" class="continue-shopping">繼續購物</a>
    </main>

    <footer>
        <p>&copy; 2024 Glitch Mall - 惡搞商品專賣店</p>
    </footer>

    <script src="assets/js/easter.js"></script>
</body>
</html> 