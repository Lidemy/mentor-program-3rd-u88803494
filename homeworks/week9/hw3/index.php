<?php 
    require_once('./conn.php');

    function notLogedIn() {
        echo '<div class="member">';
        echo   '<a href="./login.php" >登入</a> ';
        echo   '<a href="./register.php">註冊</a>';
        echo '</div>';
        echo '<div class="member__notice">需要登入才可以留言哦！如果沒有帳號請註冊</div>';
    }

    function signedIn($id, $conn) {
        $sql = "SELECT * FROM `hugh_member` WHERE `id` = $id";
        $result = $conn->query($sql);
        $nickname = $result->fetch_assoc()['nickname'];
        echo '<form action="./handle_index.php" method="post" class="new">';
        echo    '<a href="./signout.php">登出</a>';
        echo    '<div class="new__username">暱稱： '.$nickname.'<input type="hidden" name="nickname" value=' . $nickname . ' /></div>';
        // 寫這樣才可以隱藏資料，固定暱稱
        echo    '<div class="new__comment"><textarea name="comment" id="" cols="30" rows="10"></textarea></div>';
        echo    '<div class="new__btn"><input type="submit" value="送出留言" /></div>';
        echo '</form>';
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> [week9] hw3 會員留言板 </title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="board">
    <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
    <?php
        // 登入以及留言的部份
        if(!isset($_COOKIE["member_id"])) {
            notLogedIn();
        } else {
            signedIn($_COOKIE["member_id"], $conn);
        }
        // 顯示歷史留言的部份
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