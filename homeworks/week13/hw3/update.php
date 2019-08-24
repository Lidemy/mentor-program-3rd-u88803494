<?php
  require_once('./conn.php');
  require_once('./security_check.php');

  $id = $_GET['id'];

  require_once('./member_check.php'); // 驗證會員
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> 編輯 </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<div class="board container">
  <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
  <?php
    // 顯示歷史留言的部份
    $sql = "SELECT * FROM hugh_comments WHERE id = $id";

    $result = $conn->query($sql);
    if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
      $row = $result->fetch_assoc();
      echo "<form action='./handle_update.php' method='post' class='new'>";
      echo    "<h2> 編輯文章 </h2>";
      echo    "<div class='new__comment'><textarea name='comment' rows='10'>$row[comment]</textarea></div>";
      echo    "<input type='hidden' name='id' value=$id />";
      echo    "<input type='hidden' name='source_URL' value=$_SERVER[HTTP_REFERER] />";
      echo    "<div class='new__btn'><input type='submit' value='編輯完成' /></div>";
      echo "</form>";
    }

    $conn->close();
  ?>
  </div>
</div>

</body>
</html>