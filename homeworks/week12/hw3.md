## 請說明 SQL Injection 的攻擊原理以及防範方法
### 攻擊原理
SQL Injection 就是通過可以輸入資料的地方，利用 SQL 的語法的特性去影響 SQL 指令，讓上傳伺服器的 SQL 指令不正常發揮，進而達到攻擊的效果。
也就是如果程式設計的時候，沒有留意到需要字元檢查，那就很容易讓一些惡意的指令通過輸入夾帶進去，這些惡意的指令，就會被資料庫認為是正常的指令就這樣執行了，小則被人直接繞過登入，大則被人惡意刪除整個資料庫。

**攻擊方式詳解：**
一般在正常登入的時候，通過 SQL 指令：
` SELECT * FROM members WHERE username = 'abc' AND password = 'ccc' `
去跟伺服器撈出資料之後，只要有資料就可以確認有登入。
這時候，駭客要繞過登入的話，就可以直接在帳號的欄位內輸入 `' or 1 = 1`，這樣的話，SQL 收到的指令就變成
` SELECT * FROM members WHERE username = '' or 1 = 1 -- AND password = 'ccc' `
這種情況下， where 的條件就一定會得到 ture，然後密碼的部份，也因為兩條 hyphen 變成註解了。
用下面的圖片來說，一撈就把資料都撈到了，所以就可以通過登入了。

![enter image description here](https://i.imgur.com/ZaU6bGg.gif%5D%28https://i.imgur.com/ZaU6bGg.gif)

這一切都是因為設計的時候沒有考慮到字符需要轉換的問題，所以使用者輸入的內容，就輕易的被當作是程式的一部分。

### 解決方法
解決方法就是記得要字符轉換，這樣才不會被當做是程式的一部分
參考 [W3C PHP  Prepared Statements](https://www.w3schools.com/php/php_mysql_prepared_statements.asp) 通過這個方法，就可以避開解決這種狀況。
使用 
```
$stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");  
$stmt->bind_param("sss", $firstname, $lastname, $email);
```
透過這種方式可以設定每個變數的值是什麼型態，進而達到防止 SQL Injection。

```$stmt = $conn->prepare("SELECT * FROM users WHERE username=? and password=?");```

要把每個值設為 ?

```$stmt->bind_param("ss", $username, $password);```

第一格的 s 是 string 字串的意思，有幾個字串就要加幾個 s，當然如果有別種資料，就是要用別種的英文。後面是變數，有幾個變數就要加幾個，要跟前方的 ? 對應。在這種情況下的執行方法也不太一樣。

```$stmt->execute();```

然後就可以使用這個指令執行。


## 請說明 XSS 的攻擊原理以及防範方法
### 攻擊原理
XSS 是跨網站指令碼的意思，是利用一些巧妙的方法，在網站上面寫入指令，通常是因為網頁開發的時候留下的漏洞。像是網站上面的留言功能，如果沒有做過處理，那麼使用者就可以在網頁上面放上指令，像是使用 HTML 標籤，甚至是 CSS 語法，直接把整個網頁弄的亂七八糟，或是使用 JavaScript 的語法，把整個網站的資料拿走都有可能。這會造成很多災難，像是直接使用導向的語法把網站導向別的網站，或是釣魚網站等等的，就會給用戶形成一場災難。只要可以執行 JavaScrip 的地方，就可以做任何想做的事情像是竄改頁面、偷改連結、偷 cookie 等等。

![f](https://i.imgur.com/sXgPcH4.gif)
通過送出針對 body 的 CSS，把整個網頁背景都變成紅色了。

而 XSS 又分了好幾種：
#### 1. Stored XSS (儲存型)

顧名思義就是把資料儲存在資料庫裡面的攻擊方式。像是留言板、論壇文章、部落格等地方，只要是使用者可以任意輸入內容的地方，而資料處理過，只要使用者輸入各種 HTML 標籤，之後上傳，就會被儲存到資料庫內部。當後來有其他使用者讀取到這個網頁的時候，從資料庫下載代碼之後填入就會被當成語法執行。

#### 2. Reflected XSS (反射型)

Reflected XSS 指的是不被儲存在資料庫的攻擊方式。
通常是使用 GET 的形式得到的攻擊方式。
像是在網址中，可以使用 abc.com?name="bills" 來取得這個 GET 的 name 叫做 bills。但這時候如果把 bills 換成程式碼例如 `<script> alert(1) </script> ` 就會發現可以執行成功了。

比如說這個程式碼：
```
<?php
  echo  "<h3>hi, $_GET[name]</h3>";
  echo  "網址：$_SERVER[REQUEST_URI]";
?>
```
可以呼叫 GET 的中的 name 的資料，把 name 的值換成語法，就可以成功執行。第二行把網址顯示出來。
在 `name=` 後面直接輸入 `變色 <style> body { background : red; } </style>` ，就會發現又成功了。
![Imgur](https://imgur.com/VgPKkm2.gif)

通過這樣，就可以成功的攻擊了。

#### 3. DOM-Based XSS

DOM 是 JavaScript 動態產生網頁所使用的工具。
同樣也是從使用者輸入的內容中產生問題，一般使用 JavaScript 選資料的時候需要注意。如果讓使用在輸入的資料的時候，使用錯誤的方法插入資料。就有可能造成被值入惡意代碼的機會。
例如在使用 JavaScript 選中資料之後，使用 .innerHTML 插入資料。這時候只要使用者輸入的是 HTML 標籤或是 CSS、JavaScript 程式碼等，就會在顯示的地方，會直接被執行。因為被包裝成 DOM 物件了。

### 解決的方法
要解決前面 1. 2 兩點的方法是通過後端的方法來進行防範。解決方法就是使用：escape，跳脫。把對應的文字換成 HTML 跳脫字元。
或是在  PHP 有內建的 `htmlentities()` 或是 `htmlspecialchars()` 這也就是說在顯示資料的地方使用這個先過濾過資料之後再呈現就可以了。

第三種則是要由前端來防範，基本原理相同。不同的是要選擇正確的方法來操作 DOM。以前面舉的例子來說，因為使用了 .innerHTML，所以輸入的東西就有機會被當做是 HTML 語法，這時候只要改為使用 .innerTEXT 就可以保證是純文字，就不會被插入惡意代碼了。

### 參考資料：
[維基百科 跨網站指令碼](https://www.wikiwand.com/zh-tw/%E8%B7%A8%E7%B6%B2%E7%AB%99%E6%8C%87%E4%BB%A4%E7%A2%BC)
[【網頁安全】給網頁開發新人的 XSS 攻擊 介紹與防範](https://forum.gamer.com.tw/Co.php?bsn=60292&sn=11267)


## 請說明 CSRF 的攻擊原理以及防範方法
### 攻擊原理
CSRF, Cross-site request forgery，跨站請求偽造。通過跨網域的方式的偽造請求，讓使用者在不知不覺的情況下執行非預期的動作。這是一種讓在用戶已經登入的 Web 應用上，執行非本意的操作的攻擊方法。
跟 XSS 最大的差亦是，XSS 是在用戶使用該網站的時候，因為瀏覽中的內容有惡意代碼而被執行了，也就是說是利用用戶對特定網站的信任；CSRF 則是利用用戶儲存在網頁瀏覽器上面的憑證，來讓登入中的用戶進行非本意的操作，也就是利用網站對於用戶瀏覽器的信任。
CSRF 攻擊要成立的條件是使用者已經登入網站，而單憑瀏覽器與伺服器端之間的 Session 就確認使用者的身份，而進行的操作，只要攻擊者想要，就可以利用一些手段來欺騙用戶的瀏覽器，讓瀏覽器去執行不是使用者想要執行的動作。這種幾單的身份認證，只可以保證是發自某個用戶的瀏覽器，卻不能保證請求是用戶自願發出的。

常見的攻擊手法，以不正確的 URL 設計作為開端。例如說一間銀行轉帳的時候是使用 GET 的指令：http://www.examplebank.com/withdraw?account=AccoutName&amount=1000&for=PayeeName

這時候只要攻擊者，在另外一個網站放上 
```
<img src="http://www.examplebank.com/withdraw?account=Alice&amount=1000&for=Badman">
```
那只要該使用者 Alice 存取這個網站，而 Alice 的登入資訊還沒過期，那麼就會自動執行這個網站，接著 Alice 就會損失 1000 資金了。
通過這種方式，攻擊者就可以在各種地方放上這種網址，像是論壇、部落格等，所以伺服器只要沒有任何的防護措施，就會讓用戶受到攻擊。

而除了 GET 的請求方式之外，還有 POST 的攻擊方式，幾乎都可以達到只要看網頁或點一下就中招。

### 解決方法
跟 XSS 同為透過跨站請求來發動攻擊的 CSRF，是因為未落實身份確認所致，防禦時可以從這裡著手。
#### 使用者方面
這項攻擊可行的原因是因為使用者在登入狀態下才可以達成的。所以使用者應該盡量不使用自動登入。伺服器也要讓使用者在一段時間之後就自動登出，令 session 失效，就可以減少 CSRF 攻擊的可能性。
還有一種是關閉 JS 的功能，但這對大多數網頁都依賴 JS 來執行的話，就會少了很多可用的網站了。
#### 伺服器方面
剩下主要都是伺服端要負責的，像是網頁的部份，應該要盡量有著安全性更高的操作。正確的 URL 設計可以降低被攻擊的可能性。
**檢查 referer 欄位**
在 header 中有一個 referer 欄位，可以讓使用者帶上來的使後檢查這個欄位，如果帶上來的資料是安全的網頁就通過認證。只可惜 referer 這個欄位是可以篡改。所以這種方式並不是很安全，只能算是個比較便宜行事的方法。
**驗證方式**
可以通過 email 收驗證信、手機收驗證碼或是圖形驗證碼，還有更多的方式，像是 Google 的我不是機器人驗證等。這會是比較安全的作法，缺點是每次使用者都要輸入這些的話，他們可能會覺得很煩。
所以要用這種方法，較好的方式是根據發出的請求來變更驗證的難度，就像網路銀行那樣，一般登入可能只需要帳號密碼還有代號。但當需要轉帳的時候，這牽扯到金錢的問題，就可以讓使用者一定要通過手機收驗證碼的方式來認證，就可以保證其安全。
**CSRF token**
在使用者的表單內，另外新增一個隱藏欄位 CSRF token 放置由伺服器或是客戶端生成的 token，當送出表單的時候，通過驗證確認是不是使用者通過同一個來源發出的 request。
**瀏覽器本身的防禦**
現在瀏覽器已經有安全機制可以防護這點了。目前 Chrome 與 Opera 上實現了 SameSite。這種方法就是只要在設置 Cookie 的時候加上一個 SameSite 的指令，讓瀏覽器接收跨站請求的時候，就不會自動帶上 Cookie。

但在這邊有罪重要的一點，就是不要相信客戶端的 Session，最好的方式還是加強使用者的身份辨認機制。

### 參考資料：
[wiki 跨站請求偽造](https://www.wikiwand.com/zh-tw/%E8%B7%A8%E7%AB%99%E8%AF%B7%E6%B1%82%E4%BC%AA%E9%80%A0)
[從防禦認識CSRF](https://www.ithome.com.tw/voice/115822)
[讓我們來談談 CSRF](https://blog.techbridge.cc/2017/02/25/csrf-introduction/)