<?php
require_once('./conn.php');

$username = $_POST['username'];
$password = $_POST['password'];

// 判斷帳號
if (!ctype_alnum($username)) { // 判斷是否為英文數字
    die('只能是英文數字<br>'. '<a href="./login.php">回到上層重新登入</a>');
} else if (empty($username) || empty($password)) {
    die('請輸入正確帳號密碼<br>' . '<a href="./login.php">回到上層重新登入</a>');
}

$sql = "SELECT * FROM `hugh_member` WHERE `username` = '$username' AND `password` = '$password'";
  
$result = $conn->query($sql);
$id = $result->fetch_assoc()['id']; // 取出 id 值
if ($id) { // 確認有無 ID 
    setcookie("member_id", $id, time()+3600*24); // 埋 cookie
    header('Location: ./index.php');
  } else {
    echo '帳號或密碼錯誤，請重新確認';
  }
?>

