<?php 

  // 改作取得資料 user_id
  function mumberCheck($conn) {
    $sql = "SELECT M.id FROM hugh_member_certificate AS C 
      LEFT JOIN hugh_member AS M ON C.username = M.username 
      WHERE certificate_id = '$_COOKIE[certificate]'";
    $result = $conn->query($sql);
    if (!$result || $result->num_rows <= 0) {
      return null;
    } else {
      $row = $result->fetch_assoc();
      return $row['id'];
    }
  }

  if(isset($_COOKIE["certificate"]) || !empty($_COOKIE["certificate"])) {
    $user = mumberCheck($conn);
  } else {
    $user = null;
  } // 改成通過 certificate 取得 user 資料，這資料就可以用來驗證跟撈資料

  // 沒抓到使用者資料就導到首頁。防堵沒權限做修改。
  if($_SERVER['PHP_SELF'] !== '/group4/hugh/week11/index.php') { // 排除首頁，因為首頁有另外的用途
    if(!$user) {
      die(header('Location: ./index.php')); // 加入 die 才不會繼續執行
    }
  }
  
?>
