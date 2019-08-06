<?php
  require_once('./conn.php');
  require_once('./security_check.php');

  $id = $_GET['id'];
  
  $sql = "DELETE FROM `hugh_comments` WHERE id = $id OR parent_id = $id";
  // 刪除主留言的時候，一併刪除子留言，子留言的 id 傳上去，即使沒東西一樣可以刪除。

  if($conn->query($sql)) {
    header("Location: $_SERVER[HTTP_REFERER]");
  } else {
    die("failed: $conn->error");
  }
  
  $conn->close();
?>