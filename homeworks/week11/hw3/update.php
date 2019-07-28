<?php
  require_once('./conn.php');

  $id = $_GET['id'];
  $user_id = $_GET['user_id'];

  $sql = "SELECT * FROM hugh_comments WHERE id = $id";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> 編輯 </title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="board">
  <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
  <?php
    // 改為偵測防堵直接網址連進來。
    if(!isset($_COOKIE["certificate"])) {
      die('你沒有權限');
    }
    // 顯示歷史留言的部份
    $sql = "SELECT * FROM hugh_comments WHERE id = $id"; // 直接在伺服器選取前 20 筆

    $result = $conn->query($sql);
    if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
      $row = $result->fetch_assoc();
      echo "<form action='./handle_update.php' method='post' class='new'>";
      echo    "<h2> 編輯文章 </h2>";
      echo    "<div class='new__comment'><textarea name='comment' cols='30' rows='10'>$row[comment]</textarea></div>";
      echo    "<input type='hidden' name='id' value=$id />";
      echo    "<input type='hidden' name='user_id' value=$user_id />";
      echo    "<div class='new__btn'><input type='submit' value='編輯完成' /></div>";
      echo "</form>";
    }
  ?>
  <input type='hidden' name='id' value=$id />
  <input type='hidden' name='user_id' value=$user_id />
</div>
</div>
</body>
</html>