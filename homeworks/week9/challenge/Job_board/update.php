<?php 
	require_once('./conn.php');
	$id = $_GET['id'];

	$sql = "SELECT * FROM hugh_jobs WHERE id = ". $id;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title> Job board 職缺報報 編輯職缺</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="container">
		<h1> Job board 職缺報報 編輯職缺</h1>
		<a href="./admin.php">回到管理頁</a> 
		<form action="./handle_update.php" method="post">
			<div>職缺名稱：<input type="text" name="title" value="<?php echo $row['title']?>"/></div>
			<div>職缺描述：<textarea name="description" id="" cols="" rows="10"><?php echo $row['description']?></textarea></div>
			<div>薪水範圍：<input type="text" name="salary" value="<?php echo $row['salary']?>"/></div>
			<div>職缺連結：<input type="text" name="link" value="<?php echo $row['link']?>"/></div>
			<div>優先度：<input type="text" name="priority"  placeholder="最大值255" value="<?php echo $row['priority']?>"/></div>
			<div>職缺到期日<input type="date" name="due_date" value="<?php echo $row['due_date']?>"></div>
			<input type="hidden" name="id" value="<?php echo $row['id']?>">
			<input type="submit" value="送出" />
		</form>
	</div>
</body>

</html>


<?php

?>