<?php require_once('./conn.php') ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> [week9] hw2 留言板 </title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="board">
    <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
    <form action="./handle_index.php" method="post" class="new">
        <div class="new__username">暱稱：<input type="text" name="nickname" /></div>
        <div class="new__comment"><textarea name="comment" id="" cols="30" rows="10"></textarea></div>
        <div class="new__btn"><input type="submit" value="送出留言" /></div>
    </form>

    <?php
        $sql = "SELECT * FROM hugh_comments ORDER BY created_at DESC LIMIT 20"; // 直接在伺服器選取前 20 筆
        $result = $conn->query($sql);
		if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
			while($row = $result->fetch_assoc()) {
                echo '<div class="original＿＿board">';
                echo   '<div class="original＿＿nickname">' . $row['nickname'] . '</div>';
                echo   '<div class="original＿＿createdAt">留言時間：' . $row['created_at'] . '</div>';
                echo   '<div class="original＿＿comment">' . $row['comment'] . '</div>';
                echo '</div>';
			}
		}
        ?>
</div>
</body>
</html>