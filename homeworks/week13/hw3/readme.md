#### 因為寫一寫太複雜才想到應該要寫這個作為紀錄，所以並沒有全部紀錄下來

### 待新增功能
- ~~admin.php 的狀態，顯示的留言如果是子留言，就另外顯示連接，點了之後顯示單篇主留言加上該篇全部的子留言，當然也只能編輯刪除自己的文章~~ 後續改 ajax 不需要

## 之後的想法
- 可能想要改成 class 的形式，因為 function 越包越多，然後變數一多也變得看起來有些混亂。但因為不熟悉物件導向，怕寫壞XD

# 修改功能 2019/08/21 w13h3

## 實際修改
- 
### index.js
#### 新增功能
- 最終定案使用偵測 submit 行為
- ajax 可以發送資料
- ajax 可以接收伺服器的 json
- 成功與否判斷回傳的資料裡面有 id 嗎？有就是成功
- 判斷點擊的地方是子留言還是主留言
- render 主留言跟子留言

### handle_add.php
- 把原本的錯誤訊息改成 json
- 改成成功之後，把最新一筆新增的資料抓取下來
- 把抓下來的資料直接轉成 json 格式的資料後印出

# 修改功能 2019/08/21 w13h3

## 實際修改
- security_check.php 改成驗證伺服器的 session 有沒有資料
- member_check.php 驗證失敗之後回傳 JSON
- handle_delete.php 成功失敗改回傳 JSON

### index.js
#### 刪除功能
- 偵測 `.original__nickname` 底下的 `.member__delete` 
- ajax 利用刪除時候，`.closest()` 的指令有沒有抓到指定要刪除的東西來判斷刪除的是主留言還是子留言
- ajax 因應 api 改變，所以除了成功不顯示訊息之外，其他的就直接 alert 印出失敗原因


#### 新增留言功能
- 因為 CSS 已經添加 new 的 class，所以就可以使用一條 function 抓到兩種新增的功能。

### CSS
- 針對新增子留言也下 new 的 class 以方便抓取，然後就可以把重複的屬性刪掉


# 修改功能 2019/08/20 w13h3

## 實際修改
- update.php 引入 bootstrap，並添加 container 使整個板型跟 index.php 看起來差不多

#### SQL injection
- handle_update.php
- handle_delete.php
- handle_add.php

#### index.js
- 發現可以選底下的元素監聽，所以改變形式

#### security_check.php
- 發現 session 在伺服器過期被清空，但瀏覽器的卻不會清空，所以針對這點做處理
- `session_start();` 底下新增判斷，判斷伺服器上的 session 裡面到底有沒有資料，如果沒有的話，就把摧毀這個 session 並且登入參數改為 false 

# 修改功能 2019/08/19 w13h3

## 實際修改
- 測試 ajax 的功能。
- GET 的部份正在看如何抓到當前的 classname 進而取得上面的數據
- 使用 POST 的時候也一樣，需要撈到當前點選的
- 使用 `$(e.target)` 就可以抓到資料，也可以抓到值了。
- 可以使用 ajax 發出 request，但收到的資料卻無法處理，也不知道發回來的資料用那種形式是否正確。


# 修改功能 2019/08/18 w13h3

## 實際修改
- 把主留言跟子留言改一下，變成同色，方法是套用同樣的 CSS。所以把原本的 subComments() 內部變數 `$is_main` 由直接輸出屬性，改成輸出 class name。就可以達到
- 取消 board 的顏色，因為看了一下發現顏色會太雜亂
- 把每一個區塊都修改成 block
- 發現沒改到的地方，分頁功能
- navbar 固定在上方，針對 navbar 下 fixed 跟 top、left、right 即可。另外加上透明度，用途為好玩試試看
- 美化新增的區塊
- 發現 classname 的底線不小心用到全形，現在全部修正了

#### 分頁功能 numPages
- 分頁改成 bootstrap 樣式
- 套用 bootstrap 樣式並改寫進入 function numPages 內
- 套用 bootstrap 樣式的最前頁、最後頁功能，並自動帶入需要值
- 新增變數 `$disabled` 並用三元運算子判斷，是否當前頁面
- 發現 bootstrap 樣式的按鈕是用來快速前進前一頁後一頁，不過都實作了就不改變了
- 發現 bootstrap 的分頁樣式會覆蓋 navbar，所以給 navbar 增加 `z-index: 1;` 的屬性

#### member_check.php
- 使用者送出刪除跟編輯資料的時候，確認使用者資料有無相符
- 新增新的會員驗證，用在驗證刪除編輯的時候。發文不用，因為發文是直接取 session 內部紀錄的 login_id
- 利用資料庫撈資料抓到文章作者 user_id，然後跟 session 的 login_id 做驗證。

#### AJAX
- 因應刪除範圍不同，所以針對不同的位置的刪除編輯鍵，添加 css 子屬性作為區分
- 新增兩個判斷式，分別可以刪除主留言/子留言
- 構思完成，需要先發 ajax 給執行的 php，這也可以稱為 api 了，然後在讓 api 回應資料。接著接收資料之後根據這個資料來判斷有無成功。

# 修改功能 2019/08/17 w13h3

## 實際修改
- 調整配色
- textarea 設成 `width:100%;`
- 每區塊留言新增邊框，並且改成圓角
- body 新增背景色
- 留言改成白底
- 主留言跟子留言是主留言作者同一人就同色
- board 改成 `max-width:600px;`

# 修改功能 2019/08/16 w13h3

## 實際修改
- 移除所有自寫的 session 機制
- 引用 bootstrap 新增 navbar
    - index.php
    - admin.php
- 登入界面以及留言界面整個切開來

#### handle_register.php
- 變更為註冊成功即登入
- 因為需要使用者 id，所以另外抓取 id。

#### security_check.php
- 刪除原本自寫的 session 機制
- 確認改成 `$login` 確認

#### utils.php
- 主留言用 div 包起來
- 新增 `loginInterface()` 給 navbar 使用
- 刪除所有 function 內的登入、註冊、登出、回到首頁、管理介面功能。集中給 `loginInterface()` 管理。
- admin.php 的 function userInterface() 直接改成取得暱稱

#### css
- 新增 .board 背景色並套用 .container，達成 RWD 效果
- 因應前面子留言跟主留言同作者變色，就把主留言也變色。
- 非主留言作者的子留言，也給予顏色，讓留言看起來像一塊塊的方塊
- 其餘細節修飾

#### navbar 
- 新增登入的介面，並套用跟引入參數 `loginInterface($login, $page_is)`


# 修改功能 2019/08/15 w13h3

## 實際修改
#### security_check.php
- 原本的檢驗機制改成，不抓取資料了，因為已經透過登入的時候處理好了。
- 驗證機制改為簡單的登入就把 login 變數設為 true 並且 `session_start();`
- 經測試之後 session 的資料在 function 直接呼叫，所以就可以減少很多的變數應用。

#### utils.php
- 將這邊的 `$user` 也就是使用者 id 的部份，通通用 `$_SESSION['login_id']` 取代
- 將 `$user_nickname` 也就是使用者暱稱，通通改用 `$_SESSION['login_nickname']` 取代
- 因應登出的部份把 admin.php 的留言撈資料的 Ιd 直接從 session 取得： `$login_id = $_SESSION['login_id'];`
- 因應編輯刪除的功能，再沒有 cookie 也就是登出的時候照樣會執行。就使用引入的 `$login` 來判斷，沒有登入就直接不顯示。指令：`if ($login) echo memberInterface($row['user_id'], $row['parent_comment_id']);`

#### index.php & admin.php
- handle_login 改為把使用者資料新增至 session 
- handle_login 使用者資料新增的變數名稱使用 login_id、login_username、login_nickname 以方便辨別
- 刪掉許多引入的使用者 id 以及 nickname。因為可以通過 session 取得了。
- commnets 新增引入 `$login`。

# 修改功能 2019/08/14 w13h3

## 實際修改
- handle_signout.php 發現因為 `setCookie()` 的第三個參數要設置路徑，設置成功之後就可以，所以改回使用 `session_unset();` 



# 修改功能 2019/08/13 w13h3

## 實際修改
- 改成內建 session 機制
    - handle_login.php 利用 `session_start();` 取代 cookie 方案

#### handle_signout.php 
無法使用 `session_unset();` + `session_destroy();` 清除瀏覽器的 cookie。
必須使用
```
  //2、清空session資訊
  $_SESSION = array();
  //3、清除客戶端sessionid
  if(isset($_COOKIE["PHPSESSID"])) {
    setCookie("PHPSESSID",'',time()-3600,'/');
  }
  //4、徹底銷燬session
  session_destroy();
```
才可以清除瀏覽器的 cookie，個人猜測可能跟設置的時候的路徑有關係。
![Imgur](https://i.imgur.com/JinZXpH.png)

# 修改功能 2019/08/06 w12h2

## 實際修改

### admin.php 
- 能力不足，放棄新版本的 admin
- 修改原來版本的 admin，新增分頁功能。
- 在 security_check.php 新增 $page_is 直接動態取得當前頁面資訊
- admin.php 改用首頁的留言顯示功能，但新增一些判斷：
    - SQL 指令可以選擇 admin.php 需要的內容
    - 在 admin.php 不出現新增留言跟顯示子留言的部份

### 分頁功能
- 傳入 $page_is、$user_id 後者是因為 admin 的頁面需要，所以另外加上預設值 0  
- 使之判斷頁面之後選取 SQL 指令
- 因應 admin.php 有可能剛創帳號，沒內容就去看 admin 所以判斷有資料才顯示分頁。

### 整體
- handle_add.php、handle_delete.php，轉址改成來源網址。
- handle_update 改為從 update.php 取得來源網址之後跟個表單 POST 到 handle_update，就可以利用這個資訊返回原來的網址。

# 修改功能 2019/08/05 w12h2

## 實際修改
- handle_add.php 新增檢查
- admin & index 新增 $page_is 好方便變更 SQL 指令
- 修正 function comments 使得 index 跟 admin 顯示的主留言可以分開來

### 處理
- handle_delete.php、handle_update 的轉址功能要修改為轉回原來網址
- 思考一下如何撈出主留言作者非自己的子留言

# 修改功能 2019/08/04 w12h2

## 實際修改

### function comments
- SQL 指令欄位變更名稱 main_id → parent_comment_id 以更清楚表達用途。
- 新增判斷是否有登入，來顯示要不要顯示子留言的留言功能。
- 

### 新增 function memberInterface()
- 用於管理刪除、編輯功能
- 分別傳入登入中使用者 id、comment 的作者 id、commnet 本身的 id
- 在 function 中判斷有沒有權限，有的話就出現編輯刪除功能
- 分別在 comments()、subComments() 添加上去

### 整體
- index.php 現在底部也有分頁選項了
- handle_detete.php 的 $sql 指令修改為連 parent_id 一併刪除，這樣才可以刪除子留言

#### 待處理
- [x] handle_delete.php、handle_update 的轉址功能要修改為轉回原來網址


# 修改功能 2019/08/03 w12h2

## 實際修改

### inddx.php 的 sub-comment 功能
- 切板，要讓子留言的呈現跟父留言相比有些微的內縮。
- 把新增留言的功能實作上去，並切板對齊
- handle_add.php 新增抓取 parent_id 的值
- 因應子留言的部份，function comments 需要從伺服器抓取的時候一併的把 parent_id 抓下來並傳入 function subCommentAdd
- function subCommentAdd 則是多一個欄位把前面取得的 parent_id 隱藏代入
- subComments 子留言呈現的部份。只需要帶入 parent_id 就可以完美呈現了。
- 新增子留言如果是父留言的作者留言的時候背景顏色不同。

### admin.php 的 sub-comment 功能預定
- 預計更新 admin.php 的新版本，直接跟 index.php 的部份共用 function。舊版本要繼續留下來。看是新版用新命名還是舊版本更名
- 同上，預計新增一個變數來標示是首頁還是 admin，以方便 function 判斷要用那一組 SQL 指令。
- 預計把編輯/刪除功能抽離出來，利用 function 傳入 id 來判斷有沒有刪除的權限。


### 分頁功能
- 改成 SELECT count(*) 的方式取得數量，但發現程式碼其實差不多。
- 因為有子留言功能，所以要篩選資料，去除子留言的部份。

### 整體
- 抓取頁面改為 count(*) 節省撈出來的資料，但實際發現並沒有比較少的指令。


# 修改功能 2019/08/02 w12h1

## 實際修改
把 echo 的部份通通改成雙引號包單引號

### XSS
- 把暱稱跟留言分別使用 `htmlspecialchars($row['nickname'], ENT_QUOTES, 'utf-8');` 處理之後再代入 echo
    - 處理的部份都在 utils.php 的 function

### SQL Injection
- 本身使用 !ctype_alnum() 把登入跟註冊的帳號處理過，就已經可以阻擋 SQL Injection。但阻擋的能力未知，所以還是要使用 prepare() 處理過
- prepare() 處理需要處理註冊跟登入的 SQL 指令。
    - handle_register.php
    - handle_login.php

### 整體
- 新增 `$conn->close;` 到所有有開啟資料庫的地方
- 把 `userComments()`(管理文章的界面) 新增功能：沒有文章的時候顯示提示到首頁發文
- `userInterface()` 新增 class 並把原本的 CSS 語法改到 style.css 並做了一些調整。
- 把 handle_login.php 的 function 提取到 utils.php


# 修改功能 2019/07/30 w11h3

## 實際修改
1. security_check.php 改為直接驗證 cookie 有驗證到就從伺服器撈 username id 進來。
   - 新增如果沒資料就導到首頁
   - 因為 php 無法單純取得使用的檔名，所以作業上傳之前，要修改資料夾名稱才可以上傳。
2. 開了一個 utils.php 把 funciont 放進去後另外引入。
3. index.php 因為已經在 security_check.php 的驗證中取得 user 是誰，所以改為用 user 確認有無登入。
4. 登入後的 signedIn 發文欄位修改：
   - 傳入值改為 $user
   - admin.php 後面接著的 user_id 取消
   - 撈資料的指令更簡單，通過 $user 就可以撈到需要的資料了
5. admin.php：
   - function 移至 utils.php 並引入。
   - 修改 function 改傳入 $user 並用之撈資料。
   - 取消 $user_id 的部份。因為不需要了。
6. 修改 delete.php 跟 update.php 以及其上傳功能。

# 修改功能 2019/07/29 w11h3

## 安全性檢查：
security_check.php 修改為通過伺服器的 cookie 正確性驗證
新增 admin.php 驗證功能
security_check.php 增加轉址功能。如果發現 cookie 跟伺服器上資料不對，就轉到正確的 admin.php


# 新增功能 2019/07/28 w11h3

## 安全性檢查：
另外增設一個檔案 security_check.php
1. 檢查有無 cookie
2. 執行上傳的時候 檢查身份有沒有正確
3. security_check.php 使用 function 的方式是為了避免與引入的地方的變數衝突。

### security_check.php 放置位置
1. handle_delete.php
2. handle_update.php
3. handle_add.php

## 換頁功能
1. 利用 `$_GET["page"]` 抓取到的資料來判斷 `$page` 要如何呈現
2. 新增變數 `$per` 用來調整每頁顯示數量
3. 分別傳入 function 內使用
4. comments 修改 LIMIT 的條件來達成正確的顯示


## 名稱變動
1. handle_index.php -> handle_add.php
2. delete.php -> handle_delete.php
3. signout.php -> handle_signout.php

第一個的變動的原因是原本是因為在首頁執行而使用 index 變更為 add 來表示其執行的動作。

第二個變動的原因是因為本來就是執行 handle 的事情。 

第三個變成 handle 直接導向出去，但保留 html 語法，因為之後可能用來修改美化。

## 打包成 function 
1. index.php 
 - function comments 留言的
 - function numPages 分頁
2. admin.php 
 - function userInterface 使用者的界面
 - function userComments 用戶的留言
