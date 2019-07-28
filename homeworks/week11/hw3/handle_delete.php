<?php
  require_once('./conn.php');

  $id = $_GET['id'];
  $user_id = $_GET['user_id'];
  
  require_once("./security_check.php"); 
  // 驗證會員身份，需要有 $user_id 跟 $conn

  $sql = "DELETE FROM `hugh_comments` WHERE id = $id";

  if($conn->query($sql)) {
    header("Location: ./admin.php?user_id=$user_id");
  } else {
    die("failed.");
  }
?>