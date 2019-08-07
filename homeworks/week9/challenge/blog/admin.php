<?php require_once('./conn.php');?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>BLOG 部落格</title>
</head>
<body>
<h1>管理文章</h1>
<a href="./add.php">新增文章</a>
<a href="admin_category.php">管理分類</a>
<a href="./update_about.php">編輯關於我</a>
<ul>
<?php
		$sql ="SELECT * FROM hugh_blog_articles WHERE about = '0' ORDER BY created_at DESC";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<li>";
				echo   $row['title'];
				echo   " <a href='update.php?id=$row[id]'>編輯</a>";
				echo   " <a href='delete.php?id=$row[id]'>刪除</a>";
				echo "</li>";
			}
		}
?>
</ul>
	
</body>
</html>