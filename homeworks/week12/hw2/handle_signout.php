<?php 
  require_once('./conn.php');
  $cookie_id = $_COOKIE['certificate'];
  $sql = "DELETE FROM hugh_member_certificate WHERE certificate_id = '$cookie_id'";
  echo $sql;
  if(!$conn->query($sql)) { // 刪除，刪除失敗就停止 PHP
    die("failed.");
  }

  setcookie("certificate", "", time()-3600*24); // 清除 cookie 
  header("Location: $_SERVER[HTTP_REFERER]");
  // 導回原本登出網頁。即使在 admin.php 登出也沒關係，因為有驗證，失敗就會被導到首頁

  $conn->close();
?>