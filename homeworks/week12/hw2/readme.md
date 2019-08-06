#### 因為寫一寫太複雜才想到應該要寫這個作為紀錄，所以並沒有全部紀錄下來

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

### 待新增功能
- admin.php 的狀態，顯示的留言如果是子留言，就另外顯示連接，點了之後顯示單篇主留言加上該篇全部的子留言，當然也只能編輯刪除自己的文章


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
- handle_delete.php、handle_update 的轉址功能要修改為轉回原來網址


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

## 之後的想法
1. 可能想要改成 class 的形式，因為 function 越包越多，然後變數一多也變得看起來有些混亂。但因為不熟悉物件導向，怕寫壞XD


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
