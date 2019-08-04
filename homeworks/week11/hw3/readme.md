#### 因為寫一寫太複雜才想到應該要寫這個作為紀錄，所以並沒有全部紀錄下來

## 之後的想法
1. 可能想要改成 class 的形式，因為 function 越包越多，然後變數一多也變得看起來有些混亂。
但因為不熟悉物件導向，怕寫壞XD
2. 有一些可以改成雙引號包單引號，就不會看起來整串這麼長了。也不需要字串拼接。
3. 抓取頁面改為 count(*) 節省撈出來的資料


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
