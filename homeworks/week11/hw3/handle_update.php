<?php
  require_once('./conn.php');
  require_once('./security_check.php');

  $id = $_POST['id'];
  $comment = $_POST['comment'];

	if (empty($id) || empty($comment)) {
		die('empty date');
	}

  $sql = "UPDATE hugh_comments SET comment = '$comment' WHERE id = $id";
	$result = $conn->query($sql);
	if ($result) {
		header("Location: ./admin.php");
	} else {
		die("failed. ". $conn->error);
  }
?>