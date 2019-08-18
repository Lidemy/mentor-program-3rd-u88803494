<?php
  require_once('./conn.php');
  require_once('./security_check.php');

  /*
  驗證方面：
  1. 可以改方法為 post，過來的時候夾帶 user_id 可以跟 session 的對比，
  但這樣的話 user 可以串改 user_id 的值
  2. 直接通過文章 id，撈出作者 user_id，然後跟 session 儲存的 login_id 對比
  這方法可以另外開個檔案來寫，然後在需要的地方引入就好。
  3. ajax 的方式，會不會造成上面兩者皆不行，這有待思考。
  放進 utils.php 的話要引用又要呼叫會很麻煩。
  名稱暫定為 member_check.php
  */

  $id = $_GET['id'];
  
  $sql = "DELETE FROM `hugh_comments` WHERE id = $id OR parent_id = $id";
  // 刪除主留言的時候，一併刪除子留言，子留言的 id 傳上去，即使沒東西一樣可以執行。

  if($conn->query($sql)) {
    header("Location: $_SERVER[HTTP_REFERER]");
  } else {
    die("failed: $conn->error");
  }
  
  $conn->close();
?>