<?php
	require_once("./conn.php");

	$title = $_POST['title'];
	$content = $_POST['content'];
	$category_id = $_POST['category_id'];
	$published = $_POST['published'];
	$id = $_POST['id'];

	if (empty($title) || empty($id) || empty($content) || empty($category_id)) {
		die('empty date');
	}

	$sql = "UPDATE hugh_blog_articles SET title = '$title', content = '$content', 
		category_id = '$category_id',published = '$published' WHERE id =". $id;
	$result = $conn->query($sql);
	if ($result) {
		header('Location: ./admin.php');
	} else {
		die("failed. ". $conn->error);
	}

?>