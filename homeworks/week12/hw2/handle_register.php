  <?php
  require_once('./conn.php');

  $username = $_POST['username'];
  $nickname = $_POST['nickname'];
  $password = $_POST['password'];
  $assertpassword = $_POST['assertpassword'];

  // 判斷帳號
  if (!ctype_alnum($username)) { // 判斷是否為英文數字
      die("帳號只能是英文數字<p><a href='./register.php'>回到上層繼續註冊</a>");
  } else if ($password !== $assertpassword) { // 驗證兩次密碼
      die("兩次輸入的密碼不同<p><a href='./register.php'>回到上層繼續註冊</a>");
  } else if (empty($username) || empty($nickname) || empty($password)) {
      die('請檢查資料');
  }

  // 把密碼轉為 hash 
  $hash_pw = password_hash($password, PASSWORD_DEFAULT);

  // SQL Injection 處理
  $stmt = $conn->prepare("INSERT INTO `hugh_member`(`username`, `password`, `nickname`) 
    VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $hash_pw, $nickname);
  $result = $stmt->execute();
  
  if ($result) {
   header('Location: ./login.php');
  } else {
    echo "failed: $conn->error";
  }

  $stmt->close();
  $conn->close();
?>

