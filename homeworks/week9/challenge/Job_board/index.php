<?php 
	require_once('./conn.php');

	function printJobs($sql, $conn) {
		$result = $conn->query($sql);
		if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
			while($row = $result->fetch_assoc()) {
				// 判斷寫這邊。
				$due_date = $row['due_date'];
				$datetime = date ("Y-m-d" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
				if (strtotime($due_date) >= strtotime($datetime)) {
					echo '<div class="job">';
					echo   '<h2 class="job__title">' . $row['title'] . '</h2>';
					echo   '<p class="job__desc">' . $row['description'] . '</p>';
					echo   '<p class="job__salary">薪水範圍：' . $row['salary'] . '</p>';
					echo   '<a class="job__link" href="' . $row['link'] .
						'">更多資訊</a>';
					echo "</div>";
				}
			}
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title> Job board 職缺報報</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="container">
		<h1> Job board 職缺報報 </h1>
		<div class="jobs">
		<a href="./admin.php">管理界面</a>
			<?php
			  // 印出優先度
				$sql = "SELECT * FROM `hugh_jobs` WHERE priority > 0 ORDER BY priority DESC";
				printJobs($sql, $conn);
				// 印出優先度以外的資料。
				$sql = "SELECT * FROM hugh_jobs WHERE priority = 0 ORDER BY created_at DESC";
				printJobs($sql, $conn);
			?>
		</div>
	</div>
</body>

</html>