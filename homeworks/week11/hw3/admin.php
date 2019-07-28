
<?php
  require_once('./conn.php');

  $user_id = $_GET['user_id'];

  /* 可以實作一個偵測 cookie 之後轉址到正確的 admin 網址的功能，
     目標是使用者重整之後偵測到，然後轉址*/

  function userInterface($conn, $user_id) {
    $sql = "SELECT * FROM hugh_member WHERE id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // 管理界面的提示以及歡迎
    echo '<div class="member">';
    echo  '<a href="./handle_signout.php">登出</a>';
    echo  ' <a href="./index.php">回到首頁</a>';
    echo '<div style="font-size:25px;">歡迎你 <b>' .$row['nickname']. '</b> 以下是你的留言列表</div>';
    echo '</div>';
  }

  function userComments($conn, $user_id) {
    $sql = "SELECT C.id, C.comment, M.nickname, C.created_at FROM hugh_comments AS C LEFT JOIN 
    hugh_member AS M on C.user_id = M.id WHERE C.user_id = $user_id ORDER BY created_at DESC";
    $result = $conn->query($sql);
    if ($result->num_rows>0) {
      while($row = $result->fetch_assoc()) {
        echo '<div class="original＿＿board">';
        echo "<a href='./update.php?user_id=$user_id&id=$row[id]'>編輯文章</a>";
        echo " <a href='./handle_delete.php?user_id=$user_id&id=$row[id]'>刪除文章</a>";
        echo   '<div class="original＿＿createdAt">留言時間：' . $row['created_at'] . '</div>';
        echo   '<div class="original＿＿comment">' . $row['comment'] . '</div>';
        echo '</div>';
      }
    }
  }


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
    if(!isset($_COOKIE["certificate"])) {
      header("Location: ./index.php");
    } else {
      // 使用者歡迎與操作界面
      userInterface($conn, $user_id);
      // 顯示使用者留言 
      userComments($conn, $user_id);
    }
  ?>
</div>
</body>
</html>
