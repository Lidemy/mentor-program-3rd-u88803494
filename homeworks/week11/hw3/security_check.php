<?php 
  // 防堵直接網址連進來。
  if(!isset($_COOKIE["certificate"])) {
    die('你沒有權限');
  } 

  // 驗證會員 cookie 是否符合
  function mumberCheck($conn, $user_id) {
    $sql = "SELECT  M.id, M.nickname, C.certificate_id FROM hugh_member AS M LEFT JOIN 
      hugh_member_certificate AS C ON C.username = M.username WHERE M.id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    // 不符合就停止運作
    if($row['certificate_id'] !== $_COOKIE["certificate"]) {
      die("這不是你的文章");
    }
  }

  mumberCheck($conn, $user_id);

?>
