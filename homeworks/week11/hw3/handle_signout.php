<?php require_once('./conn.php')?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> 登出 </title>
</head>
<body>
  <?php
    $cookie_id = $_COOKIE['certificate'];
    $sql = "DELETE FROM hugh_member_certificate WHERE certificate_id = '$cookie_id'";
    if(!$conn->query($sql)) { // 刪除，刪除失敗就停止 PHP
      die("failed.");
    }
    setcookie("certificate", "", time()-3600*24); // 清除 cookie 
    header("Location: ./index.php");
    // 直接導向出去，但保留 html 語法，因為之後可能用來修改美化。
  ?>
  <div>你已經登出了</div>
  <a href="./index.php"> 回到首頁 </a>
</body>
</html>