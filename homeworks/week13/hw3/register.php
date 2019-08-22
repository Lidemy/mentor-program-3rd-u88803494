<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
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
    <h4>本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼</h4>
  </form> 
  </body>
</html>
