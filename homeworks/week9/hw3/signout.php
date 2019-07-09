<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> 登出 </title>
</head>
<body>
  <?php setcookie("member_id", "", time()-3600*24); ?>
  <div>你已經登出了</div>
  <a href="./index.php"> 回到首頁 </a>
</body>
</html>