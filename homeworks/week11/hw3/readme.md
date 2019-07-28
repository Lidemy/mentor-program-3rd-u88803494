#### 因為寫一寫太複雜才想到應該要寫這個作為紀錄，所以並沒有全部紀錄下來

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

## 之後的想法
1. 可能想要改成 class 的形式，因為 function 越包越多，然後變數一多也變得看起來有些混亂。
但因為不熟悉物件導向，怕寫壞XD
2. 有一些可以改成雙引號包單引號，就不會看起來整串這麼長了。也不需要字串拼接。