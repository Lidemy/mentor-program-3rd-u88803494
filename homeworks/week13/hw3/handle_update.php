<?php
  require_once('./conn.php');
  require_once('./security_check.php');

  $id = $_POST['id'];
	$comment = $_POST['comment'];
	$source_URL = $_POST['source_URL'];

	if (empty($id) || empty($comment)) {
		die('empty date');
	}
	
	// SQL Injection 處理
	$stmt = $conn->prepare("UPDATE hugh_comments SET `comment` = ? WHERE id = ?");
  $stmt->bind_param("si", $comment, $id);
	
	if ($stmt->execute()) {
		header("Location: $source_URL");
	} else {
		die("failed: $conn->error");
	}

  $stmt->close();
  $conn->close();
?>