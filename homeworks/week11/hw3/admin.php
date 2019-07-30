
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
    <title> [week11]會員留言板 資安加強 </title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="board">
  <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
  <?php
    //if($user) {
      // 使用者歡迎與操作界面
      userInterface($conn, $user);
      // 顯示使用者留言 
      userComments($conn, $user);
   /* } else {
      header("Location: ./index.php");
    }*/
  ?>
</div>
</body>
</html>
