<?php 
  require_once('./conn.php');
  $id = $_GET['id'];
  $sql = "DELETE FROM hugh_jobs WHERE id = " . $id;
  echo $sql;
  if ($conn->query($sql)) { // 直接把資料送上去，之後判斷回傳值。
    header('Location: ./admin.php');
  } else {
    echo "failed:" . $conn->error;
  }
?>