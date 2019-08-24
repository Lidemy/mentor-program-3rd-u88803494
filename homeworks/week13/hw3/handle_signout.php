<?php 
  session_start();
  session_unset();
  setCookie("PHPSESSID",'',time()-3600*24, '/');
  session_destroy(); 
  
  header("Location: $_SERVER[HTTP_REFERER]");
  // 導回原本登出網頁。即使在 admin.php 登出也沒關係，因為有驗證，失敗就會被導到首頁
?>