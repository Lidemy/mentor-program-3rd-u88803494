<?php 
  if(isset($_COOKIE["certificate"]) || !empty($_COOKIE["certificate"])) {
    $sql = 
      "SELECT M.id, M.nickname FROM hugh_member_certificate AS C 
      LEFT JOIN hugh_member AS M ON C.username = M.username 
      WHERE certificate_id = '$_COOKIE[certificate]'";
    $result = $conn->query($sql);
    if (!$result || $result->num_rows <= 0) {
      $user = null;
      $user_nickname = null;
    } else {
      $row = $result->fetch_assoc(); // 成功就取得 user 資料
      $user = $row['id'];
      $user_nickname = $row['nickname'];
    }
  } else {
    $user = null;
    $user_nickname = null;
  } // 改成通過 certificate 取得 user 資料，這資料就可以用來驗證跟撈資料
  // 沒抓到使用者資料就導到首頁。防堵沒權限做修改。
  if(basename($_SERVER['PHP_SELF']) !== 'index.php') { // 排除首頁，因為首頁有另外的用途，否則登出狀態變成無限重新導向
     // 通過 basename()，就可以單純選中網頁名稱
    if(!$user) {
      die(header('Location: ./index.php')); // 加入 die 才不會繼續執行
    }
  }
  
  $page_is = basename($_SERVER['PHP_SELF']); // 取得頁面資訊
?>
