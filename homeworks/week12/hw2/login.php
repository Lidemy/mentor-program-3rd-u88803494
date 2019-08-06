<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title> 登入介面 </title>
</head>
<body>
    <form action="./handle_login.php" method="post" class="number">
            <div class="number__title">請輸入帳號密碼登入</div>
            <div class="number__login"><input type="text" name="username" placeholder="帳號"/></div>
            <div class="number__login"><input type="password" name="password" placeholder="密碼"/></div>
            <div class="number__login"><input type="submit" value="登入"></div>
        </form> 
    </body>
</html>
