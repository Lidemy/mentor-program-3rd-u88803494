<?php
    require_once('./conn.php');

    function notLogedIn() {
        echo '<div class="member">';
        echo   '<a href="./login.php" >登入</a> ';
        echo   '<a href="./register.php">註冊</a>';
        echo '<div class="member__notice">需要登入才可以留言哦！如果沒有帳號請註冊</div>';
        echo '</div>';
    }

    function signedIn($cookie_id, $conn) {
        // 因為傳入的是亂碼 cookie 故更名
        $sql = "SELECT M.nickname, M.id FROM hugh_member_certificate AS C LEFT JOIN 
          hugh_member AS M ON C.username = M.username WHERE C.certificate_id = '$cookie_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo '<form action="./handle_add.php" method="post" class="new">';
        echo    '<a href="./handle_signout.php">登出</a>';
        echo    " <a href='./admin.php?user_id=$row[id]'>管理界面</a>";
        echo    '<div class="new__username">暱稱： '.$row['nickname']. '<input type="hidden" name="user_id" value=' . $row['id'] . ' /></div>';
        // 寫這樣才可以隱藏資料，固定暱稱
        echo    '<div class="new__comment"><textarea name="comment" id="" cols="30" rows="10"></textarea></div>';
        echo    '<div class="new__btn"><input type="submit" value="送出留言" /></div>';
        echo '</form>';
    }

    function comments($conn, $page, $per){
        $start = ($page-1)*$per;
        
        $sql = "SELECT C.comment, C.created_at, M.nickname FROM hugh_comments AS C LEFT JOIN 
            hugh_member AS M on C.user_id = M.id ORDER BY created_at DESC LIMIT $start, $per"; // 改為利用 limit n,r
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
    }

    function numPages($conn, $page, $per){
        $sql = "SELECT * FROM `hugh_comments` WHERE 1";
        $result = $conn->query($sql);

        $total = $result->num_rows;; // num_rows 得知總共有幾筆資料 
        $pages = ceil($total/$per); // 總頁數

        echo "<div class='pages'>頁數："; // 印出頁數
        for($i = 1; $i <= $pages ;$i++) {
            if ( $page-5 < $i && $i < $page+5 ) { // 只顯示鄰近的頁面。
                #style 後面可以砍掉，等明天 css 套用即可
                echo "<a style ='margin:0 3px;' class='page' href='./index.php?page=$i'>$i</a>";
            }
        }
        echo "</div>";
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> [week11]會員留言板 資安加強 </title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="board">
    <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
    <?php

        // 判斷登入與否及留言功能的部份
        if(isset($_COOKIE["certificate"])) { // 位置交換 然後不用驚嘆號增加易讀性
            signedIn($_COOKIE["certificate"], $conn);
        } else {
            notLogedIn();
        }

        // 換頁功能
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page = 1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]+0); //把頁數變成整數
        } // 偵測需要的是第幾頁
        $per = 20; // 每頁顯示數量
        // 呈現分頁的功能
        numPages($conn, $page, $per);

        // 顯示歷史留言的部份
        comments($conn, $page, $per);

    ?>
</div>
</body>
</html>