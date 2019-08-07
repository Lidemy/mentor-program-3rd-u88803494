<?php
	require_once("./conn.php");
	$id = $_GET['id'];
	$sql = "SELECT * FROM hugh_blog_categories WHERE id=" . $id;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>BLOG 部落格</title>
</head>
	<body>
	<h1>編輯分類</h1>
	<form action="handle_update_category.php" method="POST">
		名稱：<input type="text" name="name" value="<?php echo $row['name']; ?>" />
		<input type="hidden" name="id" value="<?php echo $row['id'];?> "/>
		<input type="submit" />
</form>
	
</body>
</html>