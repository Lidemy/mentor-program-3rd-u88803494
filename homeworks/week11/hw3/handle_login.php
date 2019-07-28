<?php
require_once('./conn.php');

$username = $_POST['username'];
$password = $_POST['password'];

// 判斷輸入的資料正確性
if (!ctype_alnum($username)) { // 判斷是否為英文數字
    die('只能是英文數字<br>'. '<a href="./login.php">回到上層重新登入</a>');
} else if (empty($username) || empty($password)) {
    die('請輸入正確帳號密碼<br>' . '<a href="./login.php">回到上層重新登入</a>');
}

$sql = "SELECT * FROM `hugh_member` WHERE `username` = '$username'";
$result = $conn->query($sql); // 其實這段有撈到資料就等於確認到有帳號
$account_data = $result->fetch_assoc(); // 取得伺服器上的資料

function generatorId(){
  $id_len = 32;//字串長度
  $id = '';
  $word = 'abcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()-=ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  //字典檔 可以將 數字 0 1 及字母 O L 排除
  $len = strlen($word);//取得字典檔長度
  for($i = 0; $i < $id_len; $i++){ //總共取 幾次
        $id .= $word[rand() % $len];//隨機取得一個字元
    }
  return $id;//回傳亂數 id
}

function cookieUpdate($conn, $cookie_id, $username) {
  $sql = "INSERT INTO `hugh_member_certificate`(`certificate_id`, `username`) 
    VALUES ('$cookie_id', '$username')";
  $result = $conn->query($sql);
  if (!$result) {
      echo 'failed, ' . $conn->error;
    }
}

function deleteOldCertificate($conn, $username) {
  $sql = "DELETE FROM hugh_member_certificate WHERE username = '$username'";
  $result = $conn->query($sql);
  if (!$result) {
      echo 'failed, ' . $conn->error;
    }
}

if (password_verify($password, $account_data['password'])) { // 比對密碼
  $cookie_id = generatorId(); // 先生成後儲存，方便後續應用
  deleteOldCertificate($conn, $username); // 刪除舊 cookie
  setcookie("certificate", $cookie_id, time()+3600*24); // 埋 cookie
  cookieUpdate($conn, $cookie_id, $username);
  header('Location: ./index.php');
} else {
  echo '帳號或密碼錯誤，請重新確認';
}
?>