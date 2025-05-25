# Glitch-Mall

> 基本電商功能的 HTML + PHP 網站專案，含有簡易幽默特效 —— 期末展示。
> 有什麼想法再說，慢慢優化
---

## 專案目標

不依賴 MySQL 的購物網站，使用 Session 替代資料庫，結合互動式彩蛋設計與可擴充的結帳系統。

---

## 技術架構

- **前端**：HTML5, CSS3, JavaScript 
- **後端**：PHP，資料以 JSON 檔案儲存
- **資料持久化**：
  - 商品資料存在 `/data/products.json`
  - 訂單資料儲存在 `/data/orders/`
- **使用者狀態**：用 `$_SESSION` 管理購物車、訪客標記等

---

## 專案結構

```
glitch-mall/
├── index.php                # 首頁展示商品
├── cart.php                 # 購物車
├── checkout.php             # 結帳流程
├── play.php                 # 小遊戲彩蛋頁
├── easter.js                # Konami Code 彩蛋 JS
├── data/
│   ├── products.json        # 所有商品資料
│   └── orders/              # 每筆訂單一個 JSON 檔
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
```

---

## 商品 JSON 格式

```json
[
  {
    "id": 1,
    "name": "AI 嘲諷雨傘",
    "price": 199,
    "image": "umbrella.png",
    "stock": 10
  },
  {
    "id": 2,
    "name": "深夜 glitch 鬧鐘",
    "price": 299,
    "image": "clock.png",
    "stock": 5
  }
]
```

PHP 透過 `file_get_contents('data/products.json')` 讀取並解碼，實作商品顯示與庫存扣除。

---

## 彩蛋互動

| 觸發方式 | 效果 |
|----------|------|
| Konami Code `↑↑↓↓←→←→BA` | 啟動「塗鴉模式」 |
| 點擊頁面 | Emoji 飛舞爆炸 |
| 特定折扣碼 `EASTER2025` | 彈出尋蛋小遊戲 |
| 404 頁 | Snake 小遊戲 |
| 系統時間 23:00–05:00 | 啟動「午夜黑化模式」 |
| 結帳時 | AI 店員亂入給奇怪建議 |

---

## 結帳流程

1. 使用者點選商品 → `add_to_cart.php` 更新 Session。
2. 前往 `cart.php` 檢視與修改購物車。
3. 點選「結帳」，送出表單至 `checkout.php`。
4. `checkout.php`：
    - 檢查庫存是否足夠
    - 扣除庫存
    - 建立唯一 ID 的 `order_{timestamp}.json`
    - 回傳成功訊息（模擬寄信）

---

> ㄚ這專案我會慢慢改
