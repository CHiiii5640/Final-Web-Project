<?php
session_start();

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $orders_dir = 'data/orders';
        $products_file = 'data/products.json';
        $products = json_decode(file_get_contents($products_file), true);
        
        // 檢查庫存
        $stock_ok = true;
        foreach ($_SESSION['cart'] as $cart_item) {
            foreach ($products as &$product) {
                if ($product['id'] === $cart_item['id']) {
                    if ($product['stock'] < $cart_item['quantity']) {
                        $stock_ok = false;
                        break 2;
                    }
                }
            }
        }
        
        if (!$stock_ok) {
            echo '<div style="color: red; padding: 20px; text-align: center;">';
            echo '部分商品庫存不足，請調整購物車數量。';
            echo '</div>';
        } else {
            $total = 0;
            foreach ($_SESSION['cart'] as $cart_item) {
                $total += $cart_item['price'] * $cart_item['quantity'];
            }

            // 檢查折扣碼
            $discount = 0;
            $discount_error = false;
            if (!empty($_POST['discount_code'])) {
                if ($_POST['discount_code'] === 'EASTER2025') {
                    $discount = round($total * 0.2);
                    $total -= $discount;
                } else {
                    $discount_error = true;
                    echo '<div style="color: #f44336; padding: 10px; margin: 10px 0; background: #ffebee; border-radius: 4px;">';
                    echo '無效的折扣碼，請重新輸入';
                    echo '</div>';
                }
            }
            
            if (!$discount_error) {
                foreach ($_SESSION['cart'] as $cart_item) {
                    foreach ($products as &$product) {
                        if ($product['id'] === $cart_item['id']) {
                            $product['stock'] -= $cart_item['quantity'];
                        }
                    }
                }
                
                // 保存更新後的商品數據
                file_put_contents($products_file, json_encode($products, JSON_PRETTY_PRINT), LOCK_EX);
                
                // 創建訂單
                $order = [
                    'id' => time(),
                    'items' => $_SESSION['cart'],
                    'total' => $total,
                    'discount' => $discount,
                    'customer_info' => [
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'address' => $_POST['address']
                    ],
                    'timestamp' => date('Y-m-d H:i:s')
                ];
                
                // 保存訂單
                $order_file = $orders_dir . '/order_' . $order['id'] . '.json';
                file_put_contents($order_file, json_encode($order, JSON_PRETTY_PRINT), LOCK_EX);

                // 生成訂購者個人訊息檔案
                $customer_info = [
                    'order_id' => $order['id'],
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'address' => $_POST['address'],
                    'order_time' => date('Y-m-d H:i:s'),
                    'total_amount' => $total,
                    'discount' => $discount,
                    'items' => array_map(function($item) {
                        return [
                            'name' => $item['name'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price']
                        ];
                    }, $_SESSION['cart'])
                ];

                // 保存訂購者個人訊息
                $customer_file = $orders_dir . '/customer_' . $order['id'] . '.json';
                file_put_contents($customer_file, json_encode($customer_info, JSON_PRETTY_PRINT), LOCK_EX);
                
                $_SESSION['cart'] = [];
               /* 
                // 隨機決定是否導向驚喜頁面
                if (rand(1, 100) <= 30) { // 30% 的機率導向驚喜頁面
                    $redirect_url = 'surprise.php';
                } else {
                    $redirect_url = 'checkout_success.php?order_id=' . $order['id'];
                }
                header('Location: ' . $redirect_url);
                exit;
                
                header('Location: checkout_success.php?order_id=' . $order['id']);
                exit;
                */
                header('Location: checkout_success.php?order_id=' . $order['id']);
                exit;
            }
        }
    } catch (Exception $e) {
        echo '<div style="color: red; padding: 20px; text-align: center;">';
        echo '處理訂單時發生錯誤，請稍後再試。';
        echo '</div>';
    }
}

// 計算總金額
$total = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    $total += $cart_item['price'] * $cart_item['quantity'];
}

// AI 店員建議
$ai_suggestions = [
    "要不要考慮多買一個？第二件 8 折喔！",
    "這個商品很適合搭配你購物車裡的另一個商品呢！",
    "現在買這個，下個月會推出升級版喔！",
    "這個商品最近很受歡迎，要不要多買幾個？",
    "這個商品很適合送禮，要不要多買一個？",
    "這個商品最近在打折，要不要多買幾個？",
    "這個商品很適合搭配你購物車裡的另一個商品呢！",
    "這個商品最近很受歡迎，要不要多買幾個？"
];
$ai_suggestion = $ai_suggestions[array_rand($ai_suggestions)];
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結帳 - Glitch Mall</title>
    <link rel="icon" href="assets/favicon/favicon-index.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .checkout-form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #111;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            color: #111;
            font-weight: bold;
        }
        .order-summary {
            margin-top: 2rem;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 4px;
            color: #111;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-weight: bold;
            color: #111;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }
        .cart-total {
            font-size: 1.1rem;
            text-align: right;
            margin-top: 1rem;
            font-weight: bold;
            color: #111;
        }
        .ai-suggestion {
            margin: 1rem 0;
            padding: 1rem;
            background: #e3f2fd;
            border-radius: 4px;
            color: #1565c0;
            font-style: italic;
        }
        .discount-code {
            margin-top: 1rem;
            padding: 1rem;
            background: #f5f5f5;
            border-radius: 4px;
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
                <a href="cart.php">購物車 (<?php echo count($_SESSION['cart']); ?>)</a>
            </div>
        </nav>
    </header>

    <main class="checkout-container">
        <h2>結帳</h2>
        
        <div class="ai-suggestion">
            🤖 AI 店員建議：<?php echo ($ai_suggestion); ?>
        </div>
        
        <form class="checkout-form" method="POST">
            <div class="form-group">
                <label for="name">姓名</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">電子郵件</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="address">地址</label>
                <input type="text" id="address" name="address" required>
            </div>
            
            <div class="discount-code">
                <label for="discount_code">折扣碼（選填）</label>
                <input type="text" id="discount_code" name="discount_code" placeholder="輸入折扣碼">
                <p style="font-size: 0.9em; color: #666; margin-top: 0.5rem;">
                    提示：在網站上尋找隱藏的彩蛋，完成遊戲後可獲得折扣碼！
                </p>
            </div>
            
            <div class="order-summary">
                <h3>訂單摘要</h3>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="cart-item">
                        <span><?php echo ($item['name']); ?></span>
                        <span>x<?php echo ($item['quantity']); ?></span>
                        <span>NT$ <?php echo ($item['price'] * $item['quantity']); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="cart-total">
                    總計: NT$ <?php echo ($total); ?>
                </div>
            </div>
            
            <button type="submit" class="checkout-btn">確認訂單</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Glitch Mall - 惡搞商品專賣店</p>
    </footer>

    <script src="assets/js/easter.js"></script>
</body>
</html> 