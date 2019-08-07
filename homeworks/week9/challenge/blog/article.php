<?php 
  require_once('./conn.php');
  $id = $_GET['id'];

  // 撈出單一文章
  $sql = "SELECT A.title, A.content, C.name FROM hugh_blog_articles as A 
    LEFT JOIN hugh_blog_categories AS C ON A.category_id = C.id WHERE A.id = " . $id;

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  $title = $row['title'];
  $content = $row['content'];

  // 評論的撈資料
  $sql_comments = "SELECT C.nickname, C.comment, C.created_at FROM hugh_blog_comments AS C LEFT JOIN 
    hugh_blog_articles as A ON C.article_id = A.id WHERE C.article_id = $id ORDER BY C.created_at DESC";

  $result_comments = $conn->query($sql_comments);
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
    <a class="active" href="./index.php">首頁</a>
    <a href="./about.php">關於我</a>
  </nav>
  <div class="container" style="margin-bottom:200px;">
    <div class="single-article">
      <h1><?php echo $title; ?></h1>
      <h2>分類：<?php echo $row['name'];?></h2>
      <p>
        <?php echo $content; ?>
      </p>
    </div>
  </div>
  <hr>
  <h3>評論區</h3>
  <form action="./handle_update_comment.php" method="post" class="new" style="border: 1px dotted #000; display:inline-block; padding:5px;">
        <div class="new__username">暱稱：<input type="text" name="nickname" /></div>
        <div class="new__comment"><textarea name="comment" id="" cols="30" rows="10"></textarea></div>
        <input type="hidden" name="article_id" value="<?php echo $id; ?>"/>
        <div class="new__btn"><input type="submit" value="送出留言" /></div>
  </form>

  <div class=comments style="margin-top:20px; padding:5px; max-width: 600px;">
    <?php
      if ($result_comments->num_rows>0) {
        while($row_comments = $result_comments->fetch_assoc()) {
          echo '<div style="padding:10px 3px; margin:10px 0; border: 1px solid black;">';
          echo   '<div>暱稱：' . $row_comments['nickname'] . '</div>';
          echo   '<div>留言時間：' . $row_comments['created_at'] . '</div>';
          echo   '<div style="white-space: pre-line;">評論：<br>' . $row_comments['comment'] . '</div>';
          echo '</div>';
          echo '<br><br>';
        }
      }
    ?>
  </div>
</body>
</html>