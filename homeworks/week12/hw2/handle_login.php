<?php
  require_once('./conn.php');
  include_once('./utils.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

  // 判斷輸入的資料正確性
  if (!ctype_alnum($username)) { // 判斷是否為英文數字
      die("只能是英文數字<br><a href='./login.php'>回到上層重新登入</a>");
  } else if (empty($username) || empty($password)) {
      die("請輸入正確帳號密碼<br><a href='./login.php'>回到上層重新登入</a>");
  }

  // SQL Injection 處理
  $stmt = $conn->prepare("SELECT * FROM `hugh_member` WHERE `username` = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $result = $stmt->get_result(); // 其實這段有撈到資料就等於確認到有帳號
  $account_data = $result->fetch_assoc(); // 取得伺服器上的資料

  if (password_verify($password, $account_data['password'])) { // 比對密碼
    $cookie_id = generatorId(); // 先生成後儲存，方便後續應用
    deleteOldCertificate($conn, $username); // 刪除其他的 cookie
    setcookie("certificate", $cookie_id, time()+3600*24); // 埋 cookie
    cookieUpdate($conn, $cookie_id, $username); // 把 cookie 上傳伺服器
    header('Location: ./index.php');
  } else {
    echo '帳號或密碼錯誤，請重新確認';
  }

  $stmt->close();
  $conn->close();
?>