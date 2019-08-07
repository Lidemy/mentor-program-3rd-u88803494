<?php
	 require_once("./conn.php");
	 $sql = "SELECT * FROM hugh_blog_categories ORDER BY created_at DESC";
	 $result = $conn->query($sql);
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
	<h1>新增文章</h1>
<form action="handle_add.php" method="post">
    <div>標題：<input type="text" name="title" /></div><br>
    <div>內容：<textarea type="text" name="content" rows='30'></textarea></div><br>
    <div>
      分類：<select name="category_id" >
				<?php 
					while($row = $result->fetch_assoc()) {
						echo "<option value='$row[id]'>$row[name]</option>";
					}
				?>        
      </select>
		</div><br>
		<div>
			狀態：<select name="published">
				<option value="0">草稿</option>
				<option value="1">發怖</option>
			</select>
		</div>
    <input type="submit" />
</form>
</body>
</html>