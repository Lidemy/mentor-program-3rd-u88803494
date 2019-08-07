<?php
require_once('./conn.php');

$nickname = $_POST['nickname'];
$comment = $_POST['comment'];
$article_id = $_POST['article_id'];

if (empty($nickname) || empty($comment)) {
  die('請檢查資料');
}
echo $article_id;
$sql = "INSERT INTO hugh_blog_comments(nickname, comment, article_id) 
  VALUES ('$nickname', '$comment', '$article_id')";
echo $sql;
$result =$conn->query($sql); 

if ($result) {
  header("Location: ./article.php?id=$article_id");
} else {
  echo 'failed, ' . $conn->error;
}

?>
