<?php
require_once('./conn.php');
require_once('./security_check.php');

$comment = $_POST['comment'];
$parent_id = $_POST['parent_id'];

if (empty($comment)) {
  die('內容沒有輸入，不要留空');
}

$sql = "INSERT INTO hugh_comments(`user_id`, `parent_id`, `comment`) VALUES ($user, $parent_id, '$comment')";

$result = $conn->query($sql); 

if ($result) {
  header("Location: $_SERVER[HTTP_REFERER]");
} else {
  echo "failed: $conn->error";
}

?>
