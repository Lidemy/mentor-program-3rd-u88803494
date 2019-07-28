<?php
require_once('./conn.php');

$user_id = $_POST['user_id']; // 改為傳入使用者 id
$comment = $_POST['comment'];

require_once("./security_check.php"); 
// 驗證會員身份，需要有 $user_id 跟 $conn

$sql = "INSERT INTO hugh_comments(`user_id`, `comment`) VALUES ('$user_id', '$comment')";
  
$result = $conn->query($sql); 

if ($result) {
  header('Location: ./index.php');
} else {
  echo 'failed, ' . $conn->error;
}

?>
