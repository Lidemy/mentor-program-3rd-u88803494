<?php
  require_once('./conn.php');
  require_once('./security_check.php');
  include_once('./utils.php');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> [week13] ajax & 界面美化 </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="./index.php">隨意聊聊留言板</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="./index.php"> 首頁 <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">板規(規劃中)</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">關於這個網站(規劃中)</a>
      </li>
    </ul>
    <span class="navbar-text">
    <?php loginInterface($login, $page_is); ?>
    </span>
  </div>
</nav>

<div class="board container">
  <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
  <?php
    // 改完偵測登入值
    if($login === true) {
      signedIn();
    } else {
      notLogedIn();
    }

    // 換頁功能
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
      $page = 1; //則在此設定起始頁數
    } else {
      $page = intval($_GET["page"]+0); //把頁數變成整數
    } // 偵測需要的是第幾頁
    $per = 10; // 每頁顯示數量，低一點不然會卡
    // 呈現分頁的功能
    numPages($conn, $page, $per, $page_is);

    // 顯示歷史留言的部份
    comments($conn, $page, $per, $page_is, $login);
    
    // 底部的分頁
    numPages($conn, $page, $per, $page_is);

    $conn->close();
  ?>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="./index.js"></script>
</body>
</html>