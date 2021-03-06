<?php
require_once('./conn.php');

$username = $_POST['username'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$assertpassword = $_POST['assertpassword'];

// 判斷帳號
if (!ctype_alnum($username)) { // 判斷是否為英文數字
    die('帳號只能是英文數字<br>'. '<a href="./register.php">回到上層繼續註冊</a>');
} else if ($password !== $assertpassword) { // 驗證兩次密碼
    die('兩次輸入的密碼不同<br>'. '<a href="./register.php">回到上層繼續註冊</a>');
} else if (empty($username) || empty($nickname) || empty($password)) {
    die('請檢查資料');
}

// 把密碼轉為 hash 
$hash_pw = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO `hugh_member`(`username`, `password`, `nickname`) 
  VALUES ('$username', '$hash_pw', '$nickname')";
  
$result = $conn->query($sql);

if ($result) {
    header('Location: ./login.php');
  } else {
    echo 'failed, ' . $conn->error;
  }
?>

