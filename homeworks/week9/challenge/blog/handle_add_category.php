<?php
	require_once('./conn.php');

	$name= $_POST['name'];

	if (empty($name)) {
		die('empty date');
	}

	$sql = "INSERT INTO hugh_blog_categories(name) VALUES('$name')";
	$result = $conn->query($sql);
	if ($result) {
		header('Location: ./admin_category.php');
	} else {
		die("failed. ". $conn->error);
	}

?>