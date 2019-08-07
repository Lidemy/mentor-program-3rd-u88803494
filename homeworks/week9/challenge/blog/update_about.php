<?php
	require_once("./conn.php");
	$sql = "SELECT * FROM hugh_blog_articles WHERE about = '1'";
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
	<h1>編輯關於我</h1>
	<form action="handle_update.php" method="POST">
		<div>標題：<input type="text" name="title" value="<?php echo $row['title'];?>"/></div><br>
    <div>內容：<textarea type="text" name="content" rows="20"><?php echo $row['content'];?></textarea></div>
    <input type="hidden" name="id" value="<?php echo $row['id'];?> " />
    <input type="hidden" name="category_id" value="<?php echo $row['category_id'];?> " />
    <input type="hidden" name="published" value="<?php echo $row['published'];?> " />
		<input type="submit" />
</form>
	
</body>
</html>