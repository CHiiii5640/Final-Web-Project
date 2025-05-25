# Glitch-Mall：無 SQL 版說明文件

> 一個結合幽默、惡搞彩蛋與基本電商功能的 HTML + PHP 網站專案 —— 專為期末展示設計。

---

## ✅ 專案目標

開發一個不依賴 MySQL 的購物網站，使用 Session 替代資料庫，結合互動式彩蛋設計與可擴充的結帳系統。

---

## 🧱 技術架構（無資料庫）

- **前端**：HTML5, CSS3, JavaScript 
- **後端**：PHP 8+，資料以 JSON 檔案儲存
- **資料持久化**：
  - 商品資料存在 `/data/products.json`
  - 訂單資料儲存在 `/data/orders/`
- **使用者狀態**：用 `$_SESSION` 管理購物車、訪客標記等

---

## 📁 專案結構

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

## 📦 商品 JSON 格式

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

## 🧪 彩蛋互動

| 觸發方式 | 效果 |
|----------|------|
| Konami Code `↑↑↓↓←→←→BA` | 啟動「塗鴉模式」 |
| 點擊頁面 | Emoji 飛舞爆炸 |
| 特定折扣碼 `EASTER2025` | 彈出尋蛋小遊戲 |
| 404 頁 | Snake 小遊戲 |
| 系統時間 23:00–05:00 | 啟動「午夜黑化模式」 |
| 結帳時 | AI 店員亂入給奇怪建議 |

---

## 🚚 結帳流程（無資料庫）

1. 使用者點選商品 → `add_to_cart.php` 更新 Session。
2. 前往 `cart.php` 檢視與修改購物車。
3. 點選「結帳」，送出表單至 `checkout.php`。
4. `checkout.php`：
    - 檢查庫存是否足夠
    - 扣除庫存
    - 建立唯一 ID 的 `order_{timestamp}.json`
    - 回傳成功訊息（可模擬寄信）

---

## 🔐 安全與效能建議

- 輸出 HTML 時使用 `htmlspecialchars()` 防止 XSS
- 所有 JSON 寫入用 `file_put_contents()` 搭配 `LOCK_EX` 避免並行寫入錯誤
- 折扣碼、遊戲結果建議加密驗證（ex: `hash_hmac`）
- 所有動畫提供關閉開關，避免影響低階裝置體驗

---

## 🗓 開發建議時程

| 週 | 工作 |
|----|------|
| W1 | 設計商品資料格式、製作主頁與購物車 |
| W2 | 實作結帳與訂單記錄、完成 JSON 操作 |
| W3 | 加入彩蛋互動：Konami Code、Emoji、404 |
| W4 | 整合與測試、錄製 Demo 影片、準備報告 |

---

## 🚀 後續延伸（可加分）

- 將資料改由 SQLite / MySQL 接管（保留 JSON 格式轉換函式）
- 整合 PHPMailer 寄出訂單確認信
- 加入簡易帳號系統（可選用 Firebase Auth）

---

> 記住：你不需要很複雜的後端才能讓期末報告吸睛。只要邏輯通、互動有趣，光 JSON + 彩蛋就能贏得掌聲。
