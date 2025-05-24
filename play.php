<?php
session_start();

// 檢查是否通過折扣碼進入
if (!isset($_SESSION['easter_egg']) || $_SESSION['easter_egg'] !== 'EASTER2025') {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>尋蛋遊戲 - Glitch Mall</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .game-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            text-align: center;
        }
        .game-board {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin: 2rem auto;
            max-width: 500px;
        }
        .egg-cell {
            aspect-ratio: 1;
            background: #f0f0f0;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: transform 0.3s ease;
        }
        .egg-cell:hover {
            transform: scale(1.05);
        }
        .egg-cell.found {
            background: #4CAF50;
            color: white;
        }
        .game-info {
            margin: 1rem 0;
            font-size: 1.2rem;
        }
        .discount-code {
            margin-top: 2rem;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 8px;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Glitch Mall</h1>
            <div class="nav-links">
                <a href="index.php">首頁</a>
                <a href="cart.php">購物車 (<?php echo count($_SESSION['cart'] ?? []); ?>)</a>
            </div>
        </nav>
    </header>

    <main class="game-container">
        <h2>尋蛋遊戲</h2>
        <p>找到所有隱藏的彩蛋，獲得神秘折扣碼！</p>
        
        <div class="game-info">
            已找到: <span id="foundCount">0</span> / <span id="totalEggs">5</span> 個彩蛋
        </div>
        
        <div class="game-board" id="gameBoard"></div>
        
        <div class="discount-code" id="discountCode">
            <h3>🎉 恭喜你找到所有彩蛋！</h3>
            <p>你的神秘折扣碼是：<strong>EASTER2025</strong></p>
            <p>在結帳時使用此折扣碼可獲得 20% 的折扣！</p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Glitch Mall - 惡搞商品專賣店</p>
    </footer>

    <script>
        const BOARD_SIZE = 25; // 5x5 網格
        const EGG_COUNT = 5;
        let foundEggs = 0;
        let eggPositions = [];

        // 初始化遊戲板
        function initGame() {
            const gameBoard = document.getElementById('gameBoard');
            gameBoard.innerHTML = '';
            
            // 隨機放置彩蛋
            eggPositions = [];
            while (eggPositions.length < EGG_COUNT) {
                const pos = Math.floor(Math.random() * BOARD_SIZE);
                if (!eggPositions.includes(pos)) {
                    eggPositions.push(pos);
                }
            }
            
            // 創建格子
            for (let i = 0; i < BOARD_SIZE; i++) {
                const cell = document.createElement('div');
                cell.className = 'egg-cell';
                cell.dataset.index = i;
                cell.addEventListener('click', () => checkCell(cell));
                gameBoard.appendChild(cell);
            }
        }

        // 檢查格子
        function checkCell(cell) {
            const index = parseInt(cell.dataset.index);
            
            if (eggPositions.includes(index) && !cell.classList.contains('found')) {
                cell.classList.add('found');
                cell.textContent = '🥚';
                foundEggs++;
                document.getElementById('foundCount').textContent = foundEggs;
                
                if (foundEggs === EGG_COUNT) {
                    document.getElementById('discountCode').style.display = 'block';
                }
            } else if (!cell.classList.contains('found')) {
                cell.textContent = '❌';
                setTimeout(() => {
                    cell.textContent = '';
                }, 500);
            }
        }

        // 初始化遊戲
        initGame();
    </script>
</body>
</html> 