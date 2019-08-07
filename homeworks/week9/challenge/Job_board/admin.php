<?php require_once('./conn.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title> Job board 職缺報報 管理後台</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="container">
		<h1> Job board 職缺報報 管理後台</h1>
		<a href="./add.php">新增職缺</a> 
		<a href="./index.php">回到首頁</a>
		<div class="jobs">
			<?php
				$sql = "SELECT * FROM hugh_jobs ORDER BY created_at DESC";
				$result = $conn->query($sql);
				if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
					while($row = $result->fetch_assoc()) {
						echo '<div class="job">';
						echo   '<h2 class="job__title">' . $row['title'] . '</h2>';
						echo   "<p class='job__desc'>$row[description]</p>";
						echo   '<p class="job__salary">薪水範圍：' . $row['salary'] . '</p>';
						echo   '<p class="job__duedate">職缺到期日：' . $row['due_date'] . '</p>';
						echo   '<p class="job__priority">優先度：' . $row['priority'] . '（數字越大優先度越高）</p>';
						echo   '<a class="job__link" href="./update.php?id=' .
							$row['id'] . '">編輯職缺</a>';
						echo   ' <a class="job__link" href="./delete.php?id=' .
							$row['id']	. '">刪除職缺</a>';
						echo "</div>";
					}
				}
			?>
		</div>
	</div>
</body>

</html>