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
<h1>分類管理</h1>
<a href="./add_category.php">新增分類</a>
<a href="admin.php">管理文章</a>
<ul>
<?php
		$sql ="SELECT * FROM hugh_blog_categories ORDER BY created_at DESC";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<li>";
				echo   $row['name'];
				echo   " <a href='update_category.php?id=$row[id]'>編輯</a>";
				echo   " <a href='delete_category.php?id=$row[id]'>刪除</a>";
				echo "</li>";
			}
		}
?>
</ul>
	
</body>
</html>