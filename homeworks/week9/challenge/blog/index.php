<?php require_once('./conn.php');?>
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
    <a class="active" href="./index.php">首頁</a>
    <a href="./about.php">關於我</a>
  </nav>
  <div class="container">
    <div class="articles">
      <?php
        $sql ="SELECT * FROM hugh_blog_articles WHERE published = 1 ORDER BY created_at DESC";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<div class='article'>";
            echo   "<h1><a href='./article.php?id=$row[id]'>$row[title]</a></h1>";
            echo "</div>";
          }
        }
      ?>
    </div>
  </div>
</body>
</html>