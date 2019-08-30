<?php
  session_start(); // session 機制

  require_once('./conn.php');
  require_once('./security_check.php');

  $id = $_GET['id'];
  
  require_once('./member_check.php'); // 驗證會員

  $sql = "DELETE FROM `hugh_comments` WHERE id = $id OR parent_id = $id";
  // 刪除主留言的時候，一併刪除子留言，子留言的 id 傳上去，即使沒東西一樣可以執行。

  // SQL Injection 處理
  $stmt = $conn->prepare("DELETE FROM `hugh_comments` WHERE id = ? OR parent_id = ?");
  $stmt->bind_param("ii", $id, $id);
  
  if($stmt->execute()) {
    echo json_encode(array(
      "success" => "true",
      ), JSON_UNESCAPED_UNICODE);
    //header("Location: $_SERVER[HTTP_REFERER]");
  } else {
    echo json_encode(array(
      "success" => "failed: $conn->error",
      ), JSON_UNESCAPED_UNICODE);
    // die("failed: $conn->error");
  }
  
  $conn->close();
?>