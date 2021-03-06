<?php
    require_once('./conn.php');
    include_once('./utils.php');
    require_once('./security_check.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> [week12]會員留言板 常見漏洞補強 </title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="board">
    <div class="notice">本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</div>
    <?php
        // 改成取得一個 user 值，並要注意有 security_check.php 有無排除首頁
        // 利用 user 的值判斷登入與否及留言功能的部份
        if($user) {
            signedIn($user, $conn);
        } else {
            notLogedIn();
        }

        // 換頁功能
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page = 1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]+0); //把頁數變成整數
        } // 偵測需要的是第幾頁
        $per = 10; // 每頁顯示數量，低一點不然會卡
        // 呈現分頁的功能
        numPages($conn, $page, $per, $page_is);

        // 顯示歷史留言的部份
        comments($conn, $page, $per, $user, $user_nickname, $page_is);
        
        // 底部的分頁
        numPages($conn, $page, $per, $page_is);

        $conn->close();
    ?>
</div>
</body>
</html>