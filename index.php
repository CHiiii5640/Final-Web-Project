<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
// 讀取商品數據
$products = json_decode(file_get_contents('data/products.json'), true);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glitch Mall - 惡搞商品專賣店</title>
    <link rel="icon" href="assets/favicon/favicon-index.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      body {
          background-color: #0e0e0e;
          color: #00ffe0;
          font-family: 'Segoe UI', sans-serif;
      }

      header nav {
          background-color: #111;
          color: #00ffe0;
          padding: 1rem;
          display: flex;
          justify-content: space-between;
          align-items: center;
          box-shadow: 0 4px 12px rgba(0, 255, 224, 0.2);
      }

      header nav h1 {
          color: #00ffe0;
          text-shadow: 0 0 10px #00ffe0;
      }

      .nav-links a {
          color: #00ffe0;
          margin-left: 1rem;
          text-decoration: none;
          font-weight: bold;
      }
      .nav-links a:hover {
          color: #76fff7;
      }

      .products-grid {
          display: flex;
          gap: 2rem;
          flex-wrap: wrap;
          justify-content: center;
          padding: 2rem;
      }

      .product-card {
          background-color: #1a1a1a;
          color: #00ffe0;
          padding: 1rem;
          border-radius: 8px;
          box-shadow: 0 0 12px rgba(0, 255, 224, 0.2);
          border: 1px solid #00ffe0;
          width: 260px;
          text-align: center;
          transition: transform 0.2s;
      }

    .product-card:hover {
        transform: scale(1.08);
        box-shadow:
            0 0 12px #ff1744,
            0 0 24px #ff5252,
            0 0 32px #ff8a80;
    }
    .product-card h3 {
        color:rgb(12, 228, 95);
    }
      .price {
          color: #ff4081;
          font-weight: bold;
      }

      .description {
          font-size: 0.9rem;
          color: #b0bec5;
          margin: 0.5rem 0;
      }

      button[type="submit"] {
          background-color: #00bcd4;
          border: none;
          padding: 0.5rem 1rem;
          color: #fff;
          font-weight: bold;
          border-radius: 4px;
          cursor: pointer;
          transition: background-color 0.3s;
      }

      button[type="submit"]:hover {
          background-color:rgba(28, 242, 242, 0.92);
      }

      button[disabled] {
          background-color: #aaa;
          color: #fff;
          cursor: not-allowed;
      }

      footer {
          background-color: #111;
          color: #00ffe0;
          padding: 1rem;
          text-align: center;
          margin-top: 2rem;
          box-shadow: 0 -2px 12px rgba(0, 255, 224, 0.1);
      }

      @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
      }
      .egg-spin {
          display: inline-block;
          animation: spin 0.3s linear infinite;
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

    <main>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>

            <div class="product-card">

                <img src="assets/img/<?php echo ($product['image']); ?>" 
                     alt="<?php echo ($product['name']); ?>">

                <h3><?php echo ($product['name']); ?></h3>

                <p class="price">NT$ <?php echo ($product['price']); ?></p>

                <p class="description"><?php echo ($product['description']); ?></p>

                <p class="description">剩餘數量：<?php echo ($product['stock']); ?></p>

                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <button type="submit" <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                        <?php echo $product['stock'] > 0 ? '加入購物車' : '已售完'; ?>
                    </button>
                </form>

            </div>

            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Glitch Mall - 惡搞商品專賣店</p>
        <div style="position: fixed; bottom: 10px; right: 10px; opacity: 0.1; transition: opacity 0.3s;" 
             onmouseover="this.style.opacity='1'" 
             onmouseout="this.style.opacity='0.1'">
            <a href="enter_easter.php" class="egg-spin" style="color: #666; text-decoration: none; font-size: 22px;">🥚</a>
        </div>
    </footer>

    <script src="assets/js/easter.js"></script>
</body>
</html> 
