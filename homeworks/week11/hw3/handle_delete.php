<?php
  require_once('./conn.php');
  require_once('./security_check.php');

  $id = $_GET['id'];
  
  $sql = "DELETE FROM `hugh_comments` WHERE id = $id";

  if($conn->query($sql)) {
    header("Location: ./admin.php");
  } else {
    die("failed.");
  }
?>