// Konami Code 彩蛋
const konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
let konamiIndex = 0;

document.addEventListener('keydown', (e) => {
    if (e.key === konamiCode[konamiIndex]) {
        konamiIndex++;
        if (konamiIndex === konamiCode.length) {
            activateKonamiEaster();
            konamiIndex = 0;
        }
    } else {
        konamiIndex = 0;
    }
});

function activateKonamiEaster() {
    // 創建塗鴉模式
    const canvas = document.createElement('canvas');
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = '9999';
    document.body.appendChild(canvas);

    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // 繪製隨機線條
    function drawRandomLine() {
        ctx.beginPath();
        ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.strokeStyle = `hsl(${Math.random() * 360}, 100%, 50%)`;
        ctx.lineWidth = Math.random() * 5;
        ctx.stroke();
    }

    // 每 100ms 畫一條線
    const interval = setInterval(drawRandomLine, 100);

    // 5 秒後停止
    setTimeout(() => {
        clearInterval(interval);
        canvas.remove();
    }, 5000);
}

// 點擊頁面 Emoji 爆炸效果
document.addEventListener('click', (e) => {
    const emojis = ['🎮', '🎲', '🎯', '🎨', '🎭', '🎪', '🎫', '🎬', '🎭', '🎪'];
    const emoji = document.createElement('div');
    emoji.textContent = emojis[Math.floor(Math.random() * emojis.length)];
    emoji.style.position = 'fixed';
    emoji.style.left = e.clientX + 'px';
    emoji.style.top = e.clientY + 'px';
    emoji.style.fontSize = '24px';
    emoji.style.pointerEvents = 'none';
    emoji.style.zIndex = '9999';
    document.body.appendChild(emoji);

    // 動畫效果
    const angle = Math.random() * Math.PI * 2;
    const velocity = 5 + Math.random() * 5;
    const vx = Math.cos(angle) * velocity;
    const vy = Math.sin(angle) * velocity;
    let x = e.clientX;
    let y = e.clientY;
    let opacity = 1;

    function animate() {
        x += vx;
        y += vy;
        vy += 0.2; // 重力
        opacity -= 0.02;

        emoji.style.left = x + 'px';
        emoji.style.top = y + 'px';
        emoji.style.opacity = opacity;

        if (opacity > 0) {
            requestAnimationFrame(animate);
        } else {
            emoji.remove();
        }
    }

    animate();
});

function DarkMode() {
    const now = new Date();
    const hour = now.getHours(); 
    if (hour >= 18 || hour < 5) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
}

DarkMode();
setInterval(DarkMode, 60000);