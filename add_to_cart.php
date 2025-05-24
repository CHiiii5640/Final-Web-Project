<?php
session_start();

// 檢查是否為 POST 請求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// 獲取商品 ID
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

if ($product_id <= 0) {
    header('Location: index.php');
    exit;
}

// 讀取商品數據
$products = json_decode(file_get_contents('data/products.json'), true);

// 查找商品
$product = null;
foreach ($products as $p) {
    if ($p['id'] === $product_id) {
        $product = $p;
        break;
    }
}

// 檢查商品是否存在且有庫存
if (!$product || $product['stock'] <= 0) {
    header('Location: index.php');
    exit;
}

// 初始化購物車
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 檢查商品是否已在購物車中
$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] === $product_id) {
        $item['quantity']++;
        $found = true;
        break;
    }
}

// 如果商品不在購物車中，添加它
if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $product_id,
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => 1
    ];
}

// 重定向回首頁
header('Location: index.php');
exit; 