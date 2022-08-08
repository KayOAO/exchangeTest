
## 一個簡單的換匯API
路徑設定 :
routes\api.php

Controller :
app\Http\Controllers\ExchangeController.php
為簡易型API, 所以匯率資料未抽出到Model做處理

測試 :
tests\Feature\ExchangeTest.php

介接路徑： 
<table>
  <tr>
    <th>HTTP method</th>
    <th>URL</th>
  </tr>
  <tr>
    <td>GET</td>
    <td>/api/exchange?SourceType=TWD&TargetType=USD&Price=1000.00</td>
  </tr>
</table>

Request 參數：
<table>
  <tr>
    <th>欄位</th>
    <th>型態</th>
    <th>必填</th>
    <th>範例</th>
    <th>說明</th>
  </tr>
  <tr>
    <td>SourceType</td>
    <td>string</td>
    <td>V</td>
    <td>TWD</td>
    <td>來源幣別</td>
  </tr>
  <tr>
    <td>TargetType</td>
    <td>string</td>
    <td>V</td>
    <td>USD</td>
    <td>目標幣別</td>
  </tr>
    <tr>
    <td>Price</td>
    <td>float</td>
    <td>V</td>
    <td>1000.00</td>
    <td>金額數字</td>
  </tr>
</table>

正常回傳範例(四捨五入到小數點第二位) : 32.81

異常回傳範例 : 
{
    "status": "error",
    "msg": "Error",
    "errors": {
        "Price": [
            "The price must be a number."
        ]
    }
}