<?php
	require_once('./conn.php');

	$title = $_POST['title'];
	$content = $_POST['content'];
	$category_id = $_POST['category_id'];
	$published = $_POST['published'];

	if (empty($title) || empty($content) || empty($category_id)) {
		die('empty date');
	}

	$sql = "INSERT INTO hugh_blog_articles(title, content, category_id, published) 
		VALUES('$title', '$content', '$category_id', '$published')";
	echo $sql;
	$result = $conn->query($sql);
	if ($result) {
		header('Location: ./admin.php');
	} else {
		die("failed. ". $conn->error);
	}

?>