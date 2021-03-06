<?php
  require_once('./conn.php');
  require_once("./security_check.php"); 
  include_once("./utils.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> 管理界面 </title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="board">
  <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
  <?php
    // 使用者歡迎與操作界面
    userInterface($conn, $user);
    // 換頁功能
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
      $page = 1; //則在此設定起始頁數
    } else {
      $page = intval($_GET["page"]+0); //把頁數變成整數
    } // 偵測需要的是第幾頁
    $per = 10; // 每頁顯示數量，低一點不然會卡
    // 呈現分頁的功能
    numPages($conn, $page, $per, $page_is, $user);

    // 顯示使用者留言 
    // userComments($conn, $user);
    comments($conn, $page, $per, $user, $user_nickname, $page_is);

    // 呈現分頁的功能
    numPages($conn, $page, $per, $page_is, $user);

    $conn->close();
  ?>
</div>
</body>
</html>
