<?php
  require_once('./conn.php');

  $id = $_POST['id'];
  $user_id = $_POST['user_id'];
  $comment = $_POST['comment'];

  require_once("./security_check.php");
  // 驗證會員身份，需要有 $user_id 跟 $conn

	if (empty($id) || empty($comment)) {
		die('empty date');
	}

  $sql = "UPDATE hugh_comments SET comment = '$comment' WHERE id = $id";
	$result = $conn->query($sql);
	if ($result) {
		header("Location: ./admin.php?user_id=$user_id");
	} else {
		die("failed. ". $conn->error);
  }
?>