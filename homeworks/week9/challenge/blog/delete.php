<?php 
  require_once("./conn.php");
  $id = $_GET['id'];
  $sql = "DELETE FROM hugh_blog_articles WHERE id=" . $id;
  if($conn->query($sql)) {
    header("Location: ./admin.php");
  } else {
    die("failed.");
  }
?>