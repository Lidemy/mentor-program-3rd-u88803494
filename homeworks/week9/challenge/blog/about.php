<?php
require_once('./conn.php'); 

$sql = "SELECT * FROM `hugh_blog_articles` WHERE about = 1";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$title = $row['title'];
$content = $row['content'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Blog 部落格</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="nav">
    <h1>BLOG</h1>
    <a href="./index.php">首頁</a>
    <a class="active" href="./about.php">關於我</a>
  </nav>
  <div class="container">
    <div class="about">
      <h1><?php echo $title; ?></h1>
      <p>
        <?php echo $content; ?>
      </p>
    </div>
  </div>
</body>

</html>