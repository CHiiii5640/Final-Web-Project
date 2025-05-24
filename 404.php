<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - 找不到頁面</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            text-align: center;
        }
        .snake-game {
            margin: 2rem auto;
            border: 2px solid #333;
            background: #000;
        }
        .game-controls {
            margin: 1rem 0;
        }
        .game-controls button {
            margin: 0 0.5rem;
            padding: 0.5rem 1rem;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .game-controls button:hover {
            background: #45a049;
        }
        .score {
            font-size: 1.2rem;
            margin: 1rem 0;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Glitch Mall</h1>
            <div class="nav-links">
                <a href="index.php">首頁</a>
                <a href="cart.php">購物車</a>
            </div>
        </nav>
    </header>

    <main class="error-container">
        <h2>404 - 找不到頁面</h2>
        <p>哎呀！看來你迷路了。不如來玩個遊戲吧！</p>
        
        <div class="game-controls">
            <button id="startBtn" onclick="startGame()">開始遊戲</button>
            <button id="pauseBtn" onclick="pauseGame()">暫停</button>
        </div>
        
        <div class="score">分數: <span id="score">0</span></div>
        <canvas id="snakeGame" class="snake-game" width="400" height="400"></canvas>
    </main>

    <footer>
        <p>&copy; 2024 Glitch Mall - 惡搞商品專賣店</p>
    </footer>

    <script>
        const canvas = document.getElementById('snakeGame');
        const ctx = canvas.getContext('2d');
        const gridSize = 20;
        const tileCount = canvas.width / gridSize;
        
        let snake = [
            {x: 10, y: 10},
        ];
        let food = {x: 15, y: 15};
        let dx = 1; // 設置初始方向向右
        let dy = 0;
        let score = 0;
        let gameInterval = null;
        let isPaused = false;
        let isGameRunning = false;

        function drawGame() {
            // 清空畫布
            ctx.fillStyle = 'black';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            // 畫蛇
            ctx.fillStyle = 'lime';
            snake.forEach(segment => {
                ctx.fillRect(segment.x * gridSize, segment.y * gridSize, gridSize - 2, gridSize - 2);
            });
            
            // 畫食物
            ctx.fillStyle = 'red';
            ctx.fillRect(food.x * gridSize, food.y * gridSize, gridSize - 2, gridSize - 2);
        }

        function moveSnake() {
            const head = {x: snake[0].x + dx, y: snake[0].y + dy};
            
            // 檢查是否撞牆
            if (head.x < 0 || head.x >= tileCount || head.y < 0 || head.y >= tileCount) {
                gameOver();
                return;
            }
            
            // 檢查是否撞到自己
            for (let i = 0; i < snake.length; i++) {
                if (head.x === snake[i].x && head.y === snake[i].y) {
                    gameOver();
                    return;
                }
            }
            
            snake.unshift(head);
            
            // 檢查是否吃到食物
            if (head.x === food.x && head.y === food.y) {
                score += 10;
                document.getElementById('score').textContent = score;
                generateFood();
            } else {
                snake.pop();
            }
        }

        function generateFood() {
            food = {
                x: Math.floor(Math.random() * tileCount),
                y: Math.floor(Math.random() * tileCount)
            };
            // 確保食物不會生成在蛇身上
            snake.forEach(segment => {
                if (food.x === segment.x && food.y === segment.y) {
                    generateFood();
                }
            });
        }

        function gameOver() {
            clearInterval(gameInterval);
            gameInterval = null;
            isGameRunning = false;
            document.getElementById('startBtn').textContent = '重新開始';
            alert(`遊戲結束！你的分數是: ${score}`);
        }

        function resetGame() {
            snake = [{x: 10, y: 10}];
            dx = 1;
            dy = 0;
            score = 0;
            document.getElementById('score').textContent = score;
            generateFood();
            drawGame();
        }

        window.startGame = function() {
            if (!isGameRunning) {
                if (gameInterval) {
                    clearInterval(gameInterval);
                }
                resetGame();
                gameInterval = setInterval(() => {
                    if (!isPaused) {
                        moveSnake();
                        drawGame();
                    }
                }, 100);
                isGameRunning = true;
                isPaused = false;
                document.getElementById('startBtn').textContent = '重新開始';
                document.getElementById('pauseBtn').textContent = '暫停';
            } else {
                resetGame();
            }
        }

        window.pauseGame = function() {
            if (isGameRunning) {
                isPaused = !isPaused;
                document.getElementById('pauseBtn').textContent = isPaused ? '繼續' : '暫停';
            }
        }

        document.addEventListener('keydown', (e) => {
            if (!isGameRunning) return;

            // 防止方向鍵造成瀏覽器滾動
            if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                e.preventDefault();
            }
            
            switch(e.key) {
                case 'ArrowUp':
                    if (dy !== 1) { dx = 0; dy = -1; }
                    break;
                case 'ArrowDown':
                    if (dy !== -1) { dx = 0; dy = 1; }
                    break;
                case 'ArrowLeft':
                    if (dx !== 1) { dx = -1; dy = 0; }
                    break;
                case 'ArrowRight':
                    if (dx !== -1) { dx = 1; dy = 0; }
                    break;
            }
        });

        // 初始化遊戲
        drawGame();
    </script>
</body>
</html> 