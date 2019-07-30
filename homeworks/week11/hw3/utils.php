<?php

// index.php 的部份。
function notLogedIn() {
  echo '<div class="member">';
  echo   '<a href="./login.php" >登入</a> ';
  echo   '<a href="./register.php">註冊</a>';
  echo '<div class="member__notice">需要登入才可以留言哦！如果沒有帳號請註冊</div>';
  echo '</div>';
}

function signedIn($user, $conn) {
  // 改傳入使用者名稱
  $sql = "SELECT M.id, M.nickname FROM `hugh_member` AS M where id = '$user'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  echo '<form action="./handle_add.php" method="post" class="new">';
  echo    '<a href="./handle_signout.php">登出</a>';
  echo    " <a href='./admin.php'>管理界面</a>"; // 透過 certificate 取得資料，所以不用 id 了
  echo    '<div class="new__username">暱稱： '.$row['nickname']. '<input type="hidden" name="user_id" value=' . $row['id'] . ' /></div>';
  // 寫這樣才可以隱藏資料，固定暱稱
  echo    '<div class="new__comment"><textarea name="comment" id="" cols="30" rows="10"></textarea></div>';
  echo    '<div class="new__btn"><input type="submit" value="送出留言" /></div>';
  echo '</form>';
}

function comments($conn, $page, $per){
  $start = ($page-1)*$per;
  
  $sql = "SELECT C.comment, C.created_at, M.nickname FROM hugh_comments AS C LEFT JOIN 
      hugh_member AS M on C.user_id = M.id ORDER BY created_at DESC LIMIT $start, $per";
  $result = $conn->query($sql);
  if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
      while($row = $result->fetch_assoc()) {
          echo '<div class="original＿＿board">';
          echo   '<div class="original＿＿nickname">' . $row['nickname'] . '</div>';
          echo   '<div class="original＿＿createdAt">留言時間：' . $row['created_at'] . '</div>';
          echo   '<div class="original＿＿comment">' . $row['comment'] . '</div>';
          echo '</div>';
      }
  }
}

function numPages($conn, $page, $per){
  $sql = "SELECT * FROM `hugh_comments` WHERE 1"; // 改為 count(*)
  $result = $conn->query($sql);

  $total = $result->num_rows;; // num_rows 得知總共有幾筆資料 
  $pages = ceil($total/$per); // 總頁數

  echo "<div class='pages'>頁數："; // 印出頁數
  for($i = 1; $i <= $pages ;$i++) {
      if ( $page-5 < $i && $i < $page+5 ) { // 只顯示鄰近的頁面。
          #style 後面可以砍掉，等明天 css 套用即可
          echo "<a style ='margin:0 3px;' class='page' href='./index.php?page=$i'>$i</a>";
      }
  }
  echo "</div>";
}
// index.php 的部份。

// admin.php 的部份。
function userInterface($conn, $user) {
  $sql = "SELECT * FROM hugh_member WHERE id = '$user'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  // 管理界面的提示以及歡迎
  echo '<div class="member">';
  echo  '<a href="./handle_signout.php">登出</a>';
  echo  ' <a href="./index.php">回到首頁</a>';
  echo '<div style="font-size:25px;">歡迎你 <b>' .$row['nickname']. '</b> 以下是你的留言列表</div>';
  echo '</div>';
}

function userComments($conn, $user) {
  $sql = "SELECT C.id, C.comment, M.nickname, C.created_at FROM hugh_comments AS C LEFT JOIN 
  hugh_member AS M on C.user_id = M.id WHERE M.id = '$user' ORDER BY created_at DESC";
  $result = $conn->query($sql);
  if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      echo '<div class="original＿＿board">';
      echo "<a href='./update.php?id=$row[id]'>編輯文章</a>";
      echo " <a href='./handle_delete.php?id=$row[id]'>刪除文章</a>";
      echo   '<div class="original＿＿createdAt">留言時間：' . $row['created_at'] . '</div>';
      echo   '<div class="original＿＿comment">' . $row['comment'] . '</div>';
      echo '</div>';
    }
  }
}
// admin.php 的部份。



?>