# Glitch Mall 網站專案

一個無需資料庫的幽默風格購物網站，使用 HTML + PHP 打造，具備基礎電商功能與互動式彩蛋，為期末專案展示而設計。

---

## 專案目標

建立一個不依賴 MySQL 的電商網站，利用 PHP 的 `Session` 管理使用者狀態，並將商品與訂單資料以 JSON 檔案儲存。網站加入彩蛋特效與可擴充的結帳機制，融合娛樂與實用性。

---

## 使用技術

- **前端**：HTML5, CSS3, JavaScript
- **後端**：PHP
- **資料儲存**：
  - 商品：`/data/products.json`
  - 訂單：每筆儲存在 `/data/orders/` 中
- **狀態管理**：使用 `$_SESSION` 儲存購物車與使用者識別

---

## 專案結構

```
glitch-mall/
├── index.php            # 首頁：商品展示
├── cart.php             # 購物車頁面
├── checkout.php         # 處理結帳流程
├── play.php             # 彩蛋小遊戲頁面
├── easter.js            # Konami Code 觸發的特效腳本
├── data/
│   ├── products.json    # 商品資料清單
│   └── orders/          # 儲存每筆訂單（JSON 檔）
├── assets/
│   ├── css/             # 樣式檔案
│   ├── js/              # JavaScript 程式碼
│   └── img/             # 圖片資源
```

---

## 商品資料格式（JSON 範例）

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

PHP 使用 `file_get_contents()` 讀取 JSON，再透過 `json_decode()` 解碼，實現商品載入與庫存管理。

---

## 彩蛋功能一覽

| 觸發方式                          | 效果描述               |
|-----------------------------------|------------------------|
| `↑↑↓↓←→←→BA`（Konami Code）       | 啟動「塗鴉模式」         |
| 點擊任意頁面                      | Emoji 飛舞爆炸動畫      |
| 折扣碼輸入 `EASTER2025`           | 彈出尋蛋互動小遊戲       |
| 404 錯誤頁                        | 啟動 Snake 小遊戲       |
| 系統時間為 23:00–05:00           | 進入「午夜黑化模式」     |
| 結帳時觸發                        | AI 店員亂入亂給建議      |

---

## 結帳流程概述

1. 使用者點選商品加入購物車（`add_to_cart.php`）。
2. 在 `cart.php` 瀏覽與修改購物清單。
3. 提交表單至 `checkout.php`。
4. 系統執行以下邏輯：
   - 檢查商品庫存
   - 扣除數量
   - 建立 `order_{timestamp}.json`
   - 顯示完成頁面（模擬通知寄送）

---

> 未來加入查詢（已具備json)
