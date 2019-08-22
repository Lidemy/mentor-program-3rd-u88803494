<?php
  session_start(); // 監測 session 
  if(isset($_SESSION["login_id"]) || !empty($_SESSION["login_id"]) ||
    isset($_SESSION["login_username"]) || !empty($_SESSION["login_username"]) ||
    isset($_SESSION["login_nickname"]) || !empty($_SESSION["login_nickname"])) {
    $login = true;
  } else {
    $login = false;
  }

  // 沒抓到使用者資料就導到首頁。防堵沒權限做修改。
  if(basename($_SERVER['PHP_SELF']) !== 'index.php') { // 排除首頁，因為首頁有另外的用途，否則登出狀態變成無限重新導向
     // 通過 basename()，就可以單純選中網頁名稱
    if(!$login) {
      die(header('Location: ./index.php')); // 加入 die 才不會繼續執行
    }
  }
  
  $page_is = basename($_SERVER['PHP_SELF']); // 取得頁面資訊
?>
