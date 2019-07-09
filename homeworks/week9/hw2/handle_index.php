<?php
require_once('./conn.php');

$nickname = $_POST['nickname'];
$comment = $_POST['comment'];

if (empty($nickname) || empty($comment)) {
  die('請檢查資料');
}

$sql = "INSERT INTO hugh_comments(nickname, comment) VALUES ('$nickname', '$comment')";
  
$result =$conn->query($sql); 

if ($result) {
  header('Location: ./index.php');
} else {
  echo 'failed, ' . $conn->error;
}

?>
