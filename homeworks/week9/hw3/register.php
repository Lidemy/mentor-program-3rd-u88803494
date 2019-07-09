<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <style>
    .number {
        width: 200px;
        margin: 200px auto;
    }
    </style>
    <title> 註冊介面 </title>
</head>
<body>
    <form action="./handle_register.php" method="post" class="number">
        <div class="number__title">歡迎註冊帳號</div>
        <div class="number__login"><input type="text" name="username" placeholder="帳號" /></div>
        <div class="number__login"><input type="password" name="password" placeholder="密碼" /></div>
        <div class="number__login"><input type="password" name="assertpassword" placeholder="再輸入一次密碼" /></div>
        <div class="number__login"><input type="text" name="nickname" placeholder="你的暱稱" /></div>
        <div class="number__login"><input type="submit" value="註冊" /></div>
    </form> 
    </body>
</html>
