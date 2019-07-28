## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫
這題我也不是很清除，我只知道雜湊用了之後，就可以讓密碼看起來像亂碼。然後上次直播的時候，從老師那邊得知，雜湊是屬於有形式的儲存資料的方法，所以用在密碼上面效率不差的樣子。
剩下就是另外查資料的部份了。看了一些參考資料之後，以下是我的理解。

讓我們先來瞭解什麼叫加密 (Encryption)：
>在密碼學中，加密（英語：Encryption）是將明文資訊改變為難以讀取的密文內容，使之不可讀。只有擁有解密方法的對象，經由解密過程，才能將密文還原為正常可讀的內容。

從這邊得知道原來雜湊並不是加密，真正的加密之後會得到一組金鑰，那些資料必須用那個金鑰才可以看到內容。也就是說加密是指可逆的，就是說可以從加密後的資料通過金鑰，得到原始的內容。

雜湊 (Hashing) 的定義：
>由一串資料中經過雜湊演算法（Hashing algorithms）計算出來的**資料指紋（data fingerprint）**，經常用來識別檔案與資料是否有被竄改，以保證檔案與資料確實是由原創者所提供。

而雜湊是不可逆的，所以雜湊不是加密。雜湊通常用在驗證不需要得知內容的資料，像是密碼。通過雜湊，我們會得到一組看起來像是亂碼的值。然後當需要驗證密碼的時候，再把輸入的密碼轉換成雜湊，看是否一致，來確認是不是當初輸入的密碼。

結論就是由於他們的定義上是完全不同的東西。雜湊本身不具備加密功能，雜湊是不可逆推的。所以沒辦法用在傳遞資料上面，傳遞資料的時候是需要加密資料的。雜湊的用途在於驗證資料的正確性。雜湊在應用上除了密碼之外，還有驗證檔案正確性等用途。加密貨幣好像也是通過這種形式來產生地址。

參考資料：
 [如何區分加密、壓縮、編碼](https://blog.m157q.tw/posts/2017/12/23/differences-between-encryption-compression-and-encoding/ "Permalink to 如何區分加密、壓縮、編碼") 
[加密和雜湊有什麼不一樣？](https://blog.m157q.tw/posts/2017/12/25/differences-between-encryption-and-hashing/ "Permalink to 加密和雜湊有什麼不一樣？")
[雜湊不是加密，雜湊不是加密，雜湊不是加密。](https://dotblogs.com.tw/regionbbs/2017/09/21/hashing_is_not_encryption)


## 請舉出三種不同的雜湊函數
-   SHA 系列：
    -   SHA-0
    -   SHA-1
        -   SHA-1 已經被證明不夠安全。（在可接受的時間範圍內，可以找到內容不相同輸入卻得到相同輸出。）
    -   SHA-2
        -   SHA-256
        -   SHA-512
    -   SHA-3
        -   SHA3-256
        -   SHA3-512
-   MD5
    -   MD5 也已經被證明不夠安全。（在可接受的時間範圍內，可以找到內容不相同輸入卻得到相同輸出。）
-   BLAKE2

BLAKE2 的強度跟  SHA-2/SHA-3 差不多，是現在的主流
參考資料：
[加密和雜湊有什麼不一樣？](https://blog.m157q.tw/posts/2017/12/25/differences-between-encryption-and-hashing/ "Permalink to 加密和雜湊有什麼不一樣？")
[BLAKE2系列哈希算法](https://zhuanlan.zhihu.com/p/28563960)

## 請去查什麼是 Session，以及 Session 跟 Cookie 的差別
cookie 在使用上很方便，但因為 cookie 是處存在客戶端上面的，所以就有可能被修改資料，而做出偽造的 cookie，所以重要的資料就不能夠儲存在 cookie 中了。所以為了解決這個問題就誕生了 session，session 中的數據是保留在服務器端的。

Session 有點類似會話的概念，也就是說可以從開始對話，對方接收資料，然後回應你，緊接著又可以開始另外一個對話直到結束為止，比如從撥電話到交談、掛斷，這樣的一個會話期間，可以稱之為 Session，所以中文翻成會期似乎也不為過。
Session 的另外一個優點是「保持狀態」，是指通信交談的其中一方，可以所有的消息作關聯，使得消息之間可互相連結，並且依賴，就像是巷口的早餐店阿姨，還記得你最愛吃的火腿蛋不喜歡有美乃滋。而 Session 則是一種持久網路協定，讓Client 端與 Server 端可以作一種對話，並將兩端建立關連，保持伺服器與Client可以持續的與Server作交談。
Cookie 就像是一張號碼牌，用來確認身份而已。而 Session 就像是一張數位會員卡，晶片裡面只儲存了一些些訊息，但是當你一刷，電腦就帶出一堆資料，不僅可以記錄你的點餐號碼，還可以記憶你的餐點細節，消費記錄和點餐喜好...等。而這就解決號碼牌遺失領不到餐的問題，但是他不是記憶你帥氣得穿搭或長相，而是靠著所謂的Session ID。

Session 的運作通過一個  `session_id`  來進行。把 `session_id` 存在放客戶端的 cookie 中。當客戶端 request 資料的時候，伺服器檢查 requset 中 cookie 保存的 session_id  並通過這個 session_id 與服務器端的 session data 關聯起來，進行資料的保存和修改。

當你瀏覽一個網頁時，伺服器隨機產生字串作為 session_id ，然後保存在 cookie 中。當下次訪問時，cookie 會帶有這個字串，然後瀏覽器就知道你是上次訪問過的某某某，然後從伺服器取出上次記錄的使用者資料。

兩者間的差異是 cookie 數據保存在客戶端，session 數據保存在伺服器端。  
  
參考資料：
[Session 和 Cookie 的區別與聯繫](http://wiki.jikexueyuan.com/project/node-lessons/cookie-session.html)
[cookie 和 session](https://kknews.cc/other/gglegle.html)
[會員系統用Session還是Cookie? 你知道其實他們常常混在一起嗎？](https://progressbar.tw/posts/92)

##  `include`、`require`、`include_once`、`require_once` 的差別

include 跟 require 的差異在於警告方式不同，include 的檔案缺失只會出現警告而已，但是 require 則是會跳出錯誤並且停止運行。
require 和 include 幾乎完全一樣，除了處理失敗的方式不同之外。require 在出錯時產生 **`E_COMPILE_ERROR`** 級別的錯誤。換句話說將導致腳本中止而 include 只產生警告（**`E_WARNING`**），腳本會繼續運行。

### require V.S. include
require( )會將目標檔案的內容讀入，並且把自己本身代換成這些讀入的內容。這個讀入與代換的動作發生在 PHP 引擎編譯程式碼的時候，而不是發生在 PHP 引擎開始執行編譯好的程式碼時（PHP 3 引擎的工作方式是編譯一行，執行一行；但是到了 PHP 4 就不太一樣了，PHP 4 先把整個程式碼全部編譯完成後，再將這些編譯好的程式碼一次執行完畢，在編譯的過程中不會執行任何程式碼）。

require( ) 適合用來引入靜態的內容（如版權宣告），而 include( ) 則適合用來引入動態的程式碼（程式內容會依其他程式碼而變動）。

### include_once、require_once
這兩者用途跟同名的是一模一樣的，唯一的差別在於 include_once、require_once 不可以重複引用，使用的時候會先檢查是否已經在這個程式中的其他位置引用過了，如果有救不會再次引入。這功能算是很重要的，因為在引入的時候常常有變數已經使用過了，如果又再次引入，根據 PHP 不允許相同名稱的函數被重複宣告的機制，就會引發錯誤訊息。所以一般而言都會推薦使用 include_once、require_once。

### 總結

#### include 和 include_once
都是用來引入檔案，後者可避免重複引入，故建議用後者。引不到檔案會出現錯誤息，**但程式不會停止**。

#### require 和 require_once
 都是用來引入檔案，後者可避免重複引入，故建議用後者。引不到檔案會出現錯誤息，**而且程式會停止執行**。

參考資料：
[php.net 關於 require 的說明](https://www.php.net/manual/zh/function.require.php)
[PHP引用檔案的函數區別( REQUIRE , REQUIRE_ONCE , INCLUDE , INCLUDE_ONCE)](https://sanji0802.wordpress.com/2008/02/25/php%E5%BC%95%E7%94%A8%E6%AA%94%E6%A1%88%E7%9A%84%E5%87%BD%E6%95%B8%E5%8D%80%E5%88%A5requirerequire_onceincludeinclude_once/)
[初學者最易混淆的 include、include_once、require、require_once 之比較](https://injerry.pixnet.net/blog/post/39082306)
