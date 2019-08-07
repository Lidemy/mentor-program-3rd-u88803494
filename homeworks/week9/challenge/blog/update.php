<?php
	require_once("./conn.php");
	$id = $_GET['id'];
	$sql = "SELECT * FROM hugh_blog_articles WHERE id=" . $id;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$sql_category = "SELECT * FROM hugh_blog_categories ORDER BY created_at DESC";
	$result_category = $conn->query($sql_category);
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
	<h1>編輯文章</h1>
	<form action="handle_update.php" method="POST">
		<div>標題：<input type="text" name="title" value="<?php echo $row['title'];?>"/></div>
    <div>內容：<textarea type="text" name="content" rows="20"><?php echo $row['content'];?></textarea></div>
		<div>分類：
      <select name="category_id" value="<?php echo $row['category_id']?>">
				<?php 
					while($row_category = $result_category->fetch_assoc()) {
						$is_checked = $row['category_id'] === $row_category['id'] ? "selected" : ""; 
						// 運用三元運算子來判斷 id 是否相同，符合的就標注 selected 設於預選選項。
						echo "<option value='$row_category[id]' $is_checked>$row_category[name]</option>";
						// 接著利用 $is_checked 的儲存，把伺服器符合的選項標上 selected
					}
				?>        
      </select>
		</div>
		<div>發怖狀態：
			<select name="published">
				<option value="0" <?php if ($row['published'] === '0') echo 'selected';?>>草稿</option>
				<option value="1" <?php if ($row['published'] === '1') echo 'selected';?>>發怖</option>
			</select>
		</div>
		<input type="hidden" name="id" value="<?php echo $row['id'];?> "/>
		<input type="submit" />
</form>
	
</body>
</html>