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
          background-color: #1f1b24;
          color: #f5f5f5;
          font-family: 'Segoe UI', sans-serif;
      }

      header nav {
          background-color: #2a223a;
          color: #fff;
          padding: 1rem;
          display: flex;
          justify-content: space-between;
          align-items: center;
      }

      header nav h1 {
          color: #ff4081;
      }

      .nav-links a {
          color: #ffeb3b;
          margin-left: 1rem;
          text-decoration: none;
          font-weight: bold;
      }

      .products-grid {
          display: flex;
          gap: 2rem;
          flex-wrap: wrap;
          justify-content: center;
          padding: 2rem;
      }

      .product-card {
          background-color: #ffffff;
          color: #111;
          padding: 1rem;
          border-radius: 8px;
          box-shadow: 0 0 12px rgba(255, 64, 129, 0.3);
          width: 260px;
          text-align: center;
          transition: transform 0.2s;
      }

      .product-card:hover {
          transform: scale(1.05);
      }

      .price {
          color: #e91e63;
          font-weight: bold;
      }

      .description {
          font-size: 0.9rem;
          color: #333;
          margin: 0.5rem 0;
      }

      button[type="submit"] {
          background-color: #00e676;
          border: none;
          padding: 0.5rem 1rem;
          color: #000;
          font-weight: bold;
          border-radius: 4px;
          cursor: pointer;
          transition: background-color 0.3s;
      }

      button[type="submit"]:hover {
          background-color: #69f0ae;
      }

      button[disabled] {
          background-color: #aaa;
          color: #fff;
          cursor: not-allowed;
      }

      footer {
          background-color: #2a223a;
          color: #fff;
          padding: 1rem;
          text-align: center;
          margin-top: 2rem;
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
            <a href="enter_easter.php" style="color: #666; text-decoration: none; font-size: 12px;">🥚</a>
        </div>
    </footer>

    <script src="assets/js/easter.js"></script>
</body>
</html> 