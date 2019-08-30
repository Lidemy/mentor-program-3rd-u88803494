<?php
  session_start(); // session 機制

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
    // 建立使用者資料
    $_SESSION['login_id'] = $account_data['id'];
    $_SESSION['login_username'] = $account_data['username'];
    $_SESSION['login_nickname'] = $account_data['nickname'];

    header('Location: ./index.php');
  } else {
    die('帳號或密碼錯誤，請重新確認');
  }

  $stmt->close();
  $conn->close();
?>