<?php
	require_once("./conn.php");

	$name= $_POST['name'];
	$id = $_POST['id'];

	if (empty($name) || empty($id)) {
		die('empty date');
	}

	$sql = "UPDATE hugh_blog_categories SET name = '$name' WHERE id =". $id;
	$result = $conn->query($sql);
	if ($result) {
		header('Location: ./admin_category.php');
	} else {
		die("failed. ". $conn->error);
	}

?>