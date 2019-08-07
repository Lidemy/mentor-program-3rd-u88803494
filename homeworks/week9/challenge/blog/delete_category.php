<?php 
  require_once("./conn.php");
  $id = $_GET['id'];
  $sql = "DELETE FROM hugh_blog_categories WHERE id=" . $id;
  if($conn->query($sql)) {
    header("Location: ./admin_category.php");
  } else {
    die("failed.");
  }
?>