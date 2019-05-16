## 請以自己的話解釋 API 是什麼
API 就是一種溝通用的介面，介面原始的定義也是使兩個電子設備可以彼此溝通所使用的方式，但它是屬於較抽象化的概念，所以很難可以界定它是怎麼樣的東西。不過可以說 API 就是一個可以讓兩個不同的軟體去取得或修改資料的方法，在現在的話，則是很多平台可以讓其他人與之交換資料，或是修改資料的方式。

 
## 請找出三個課程沒教的 HTTP status code 並簡單介紹

502 Bad Gateway
這個產生的問題是比較複雜的，就是中間的閘道器有問題，因為網路連線會經過很多的閘道，只要其中的一個閘道有問題，就有可能導致錯誤，像是防火牆的阻擋，或是主機太爛無法承受太多連線都有可能會產生這種情況。

505 HTTP Version Not Supported
伺服器不支援，或者拒絕支援在請求中使用的HTTP版本。在這個回應中，是伺服器不支持該 HTTP 版本，經過查詢網路，有時候在使用指令的時候，如果多打一些空格，也可能會導致伺服器回應這樣的錯誤訊息。

414 Request-URI Too Long
指的是 url 連結的長度太長了
其實一般來說會出現Requsest-URI Too Long。就是代表了url連結長度太長了。 一般會發生這樣的情況，大多數是發生在用get方式傳送資料時發生的，get處理的容量太大時就會有這樣的錯誤。


## 假設你現在是個餐廳平台，需要提供 API 給別人串接並提供基本的 CRUD 功能，包括：回傳所有餐廳資料、回傳單一餐廳資料、刪除餐廳、新增餐廳、更改餐廳，你的 API 會長什麼樣子？請提供一份 API 文件。

  



http://www.goodfood.com/

```
"restaurant" [
  {
    "id": "1",
    "restaurant_name": "KFC",
    "restaurant_classification": "fastfood",
    "restaurant_address": "Zhongzheng Dist., Taipei City",
  },
   {
    "id": "2",
    "restaurant_name": "McDonald's",
    "restaurant_classification": "fastfood",
    "restaurant_address": "Zhongzheng Dist., Taipei City",
  },
   {
    "id": "3",
    "restaurant_name": "TGI FRIDAYS",
    "restaurant_classification": "diner",
    "restaurant_address": "Wanhua Dist., Taipei City",
  },
   {
    "id": "4",
    "restaurant_name": "FLORONSGARDEN",
    "restaurant_classification": "Restaurant & Cafe",
    "restaurant_address": "Zhongzheng Dist., Taipei City",
  },
   {
    "id": "5",
    "restaurant_name": "TASTY",
    "restaurant_classification": "bistro",
    "restaurant_address": "Wenshan Dist., Taipei City",
  },
],

```

| 說明 | Method | path | 參數 | 範例 |
|--------|--------|------------|----------------------|----------------|
| 獲取所有餐廳 | GET | /restaurant | _limit:限制回傳資料數量 | /restaurant?_limit=5 |
| 獲取單一餐廳 | GET | /restaurant/:id | 無 | /books/10 |
| 新增餐廳 | POST | /restaurant | name: 餐廳名稱 | 無 |
| 刪除餐廳 | DELETE | /restaurant/:id | 無 | 無 |
| 更改餐廳資訊 | PATCH | /restaurant/:id | 變更的項目: 內容 | 無 |



取得所有餐廳時：GET /restaurant
```
GET http://www.goodfood.com/restaurant
```

獲取其中一個餐廳時： GET　/restaurant/:id　
```
GET http://www.goodfood.com/restaurant/1
```

新增餐廳：POST /restaurant 
```
POST http://www.goodfood.com/restaurant/
```

刪除餐廳：DELETE /restaurant/:id　
```
DELETE http://www.goodfood.com/restaurant/1
```

變更餐廳資訊：PATCH restaurant/:id 
```
PATCH http://www.goodfood.com/restaurant/1
```