<?php

// index.php 的部份。
function notLogedIn() {
  echo "<div class='member'>";
  echo   "<a href='./login.php'>登入</a> ";
  echo   "<a href='./register.php'>註冊</a>";
  echo "<div class='member__notice'>需要<a href='./login.php'>登入</a>才可以留言哦！如果沒有帳號請<a href='./register.php'>註冊</a></div>";
  echo "</div>";
}

// 留言的功能。
function signedIn($user, $conn) {
  // 改傳入使用者名稱
  $sql = "SELECT M.nickname FROM `hugh_member` AS M where id = '$user'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nickname = htmlspecialchars($row['nickname'], ENT_QUOTES, 'utf-8');
  echo "<form action='./handle_add.php' method='post' class='new'>";
  echo    "<div><a href='./handle_signout.php'>登出</a>";
  echo    " <a href='./admin.php'>管理界面</a></div>";
  echo    "<div class='new__username'>暱稱：$nickname<input type='hidden' name='user_id' value=$user/></div>";
  // 寫這樣才可以隱藏資料，固定暱稱
  echo    "<div class='new__comment'><textarea name='comment' id='' cols='70' rows='10'></textarea></div>";
  echo   "<input type='hidden' name='parent_id' value='0'>"; // 新增父留言屬性
  echo    "<div class='new__btn'><input type='submit' value='送出留言' /></div>";
  echo "</form>";
}

// 主/子留言功能
function comments($conn, $page, $per, $user, $user_nickname, $page_is){
  // 傳入使用者 nickname 因為新增留言的地方需要呈現
  $start = ($page-1)*$per;
  
  if($page_is === 'index.php') {
    $sql = 
      "SELECT C.comment, C.created_at, M.nickname, C.id AS parent_comment_id, C.user_id 
      FROM hugh_comments AS C LEFT JOIN hugh_member AS M ON C.user_id = M.id
      WHERE C.parent_id = 0 ORDER BY C.created_at DESC LIMIT $start, $per";
  } else {
    $sql = 
      "SELECT C.id AS parent_comment_id, C.user_id, C.comment, M.nickname, C.created_at 
      FROM hugh_comments AS C LEFT JOIN hugh_member AS M on C.user_id = M.id 
      WHERE M.id = '$user' ORDER BY C.created_at DESC LIMIT $start, $per";
  }

  $result = $conn->query($sql);
  if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
    while($row = $result->fetch_assoc()) {
      $nickname = htmlspecialchars($row['nickname'], ENT_QUOTES, 'utf-8');
      $comment = htmlspecialchars($row['comment'], ENT_QUOTES, 'utf-8');
      echo "<div class='original＿＿board'>";
      // 刪除/編輯的界面，分別傳入登入者 id 跟 comment 作者的 id，比對成功就顯示刪除編輯功能
      echo   memberInterface($user, $row['user_id'], $row['parent_comment_id']);
      echo   "<div class='original＿＿nickname'>$nickname</div>";
      echo   "<div class='original＿＿createdAt'>留言時間：$row[created_at]</div>";
      echo   "<div class='original＿＿comment'>$comment</div>";
      // 改成有登入加上在首頁才顯示
      if($user && $page_is === 'index.php') {
        subCommentAdd($conn, $user, $row['parent_comment_id'], $user_nickname); 
        // 從伺服器上抓取下來的主留言 id(parent_comment_id) 直接傳入
        subcomments($conn, $row['parent_comment_id'], $row['user_id'], $user); 
        // 傳入主留言的使用者 id(user_id)方便比對
      }
      echo "</div>";
    }
  } else {
    echo "<div><h3>目前還沒有任何留言 <a href='./index.php'>回到首頁</a> 寫一些留言吧</h3></div>";
  }
}

// 子留言功能
function subComments($conn, $parent_id, $main_user_id, $user) { 
  // 通過 $parent_id 就可以抓到是屬於哪篇文章的子留言
  // $main_user_id 是主留言的使用者 id(user_id)
  $sql = "SELECT C.id, C.comment, C.created_at, M.nickname, C.user_id FROM hugh_comments AS C LEFT JOIN hugh_member AS M 
  ON C.user_id = M.id WHERE C.parent_id = $parent_id ORDER BY created_at DESC ";

  $result = $conn->query($sql);
  if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
    while($row = $result->fetch_assoc()) {
      $nickname = htmlspecialchars($row['nickname'], ENT_QUOTES, 'utf-8');
      $comment = htmlspecialchars($row['comment'], ENT_QUOTES, 'utf-8');
      $is_main = $main_user_id === $row['user_id'] ? "style='background:aliceblue;'" : ""; 
      // 跟主留言同作者就變色。$row['user_id'] 是這篇留言的作者 id 跟主留言作者做比較
      echo   "<div class='original__sub-comment' $is_main>";
      echo       memberInterface($user, $row['user_id'], $row['id']);
      echo     "<div class='original＿＿nickname'>$nickname</div>";
      echo     "<div class='original＿＿createdAt'>留言時間：$row[created_at]</div>";
      echo     "<div class='original＿＿comment'>$comment</div>";
      echo   "</div>";
    }
  }
}

function subCommentAdd($conn, $user, $parent_id, $nickname) {
  // 需要多傳入一個父留言 id，另傳入登入中使用者的 nickname 節省資源的撈取
  echo "<form action='./handle_add.php' method='post' class='original__sub-add'>";
  echo     "<div class='original＿＿nickname'>暱稱：$nickname</div>";
  echo    "<input type='hidden' name='user_id' value=$user/>";
  echo    "<div class='new__comment'><textarea name='comment' cols='60' rows='3'></textarea></div>";
  echo   "<input type='hidden' name='parent_id' value = '$parent_id'>"; // 新增父留言屬性
  echo    "<div class='new__btn'><input type='submit' value='送出留言' /></div>";
  echo "</form>";
}

// 分頁功能
function numPages($conn, $page, $per, $page_is, $user_id = '0'){
  if($page_is === 'index.php') {
    $sql = "SELECT count(*) FROM `hugh_comments` WHERE parent_id = 0";
  } else if($page_is === 'admin.php') {
    $sql = "SELECT count(*) FROM `hugh_comments` WHERE `user_id` = $user_id";
  }

  $result = $conn->query($sql);
  
  $total = $result->fetch_assoc()['count(*)']; // 得知總共有幾筆資料 
  $pages = ceil($total/$per); // 總頁數
  
  if ($pages) { // 因為跟 admin.php 共用，所以沒資料的時候顯示分頁很奇怪
    echo "<div class='pages'>頁數："; // 印出頁數
    for($i = 1; $i <= $pages ;$i++) {
      if ( $page-5 < $i && $i < $page+5 ) { // 只顯示鄰近的頁面。
          echo "<a class='page' href='./$page_is?page=$i'>$i</a>";
      }
    }
    echo "</div>";
  }
}

function memberInterface($login_user, $comment_user_id, $comment_id) {
  // 傳入登入者 user_id, 留言作者 userid, 留言文章id
  if ($login_user === $comment_user_id) {
    return "<div><a href='./update.php?id=$comment_id'>編輯文章</a>
       <a href='./handle_delete.php?id=$comment_id'>刪除文章</a></div>";
  }
}
// index.php 的部份。

// admin.php 的部份。
function userInterface($conn, $user) {
  $sql = "SELECT * FROM hugh_member WHERE id = '$user'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  // 管理界面的提示以及歡迎
  $nickname = htmlspecialchars($row['nickname'], ENT_QUOTES, 'utf-8');
  echo "<div class='member'>";
  echo  "<div><a href='./handle_signout.php'>登出</a>";
  echo  " <a href='./index.php'>回到首頁</a></div>";
  echo "<div class='welcome'>歡迎你 <b>$nickname</b></br> 以下是你的留言列表</div>";
  echo "</div>";
}

// 暫時用不到了
function userComments($conn, $user) {
  $sql = "SELECT C.id, C.comment, M.nickname, C.created_at FROM hugh_comments AS C LEFT JOIN 
  hugh_member AS M on C.user_id = M.id WHERE M.id = '$user' ORDER BY C.created_at DESC";
  $result = $conn->query($sql);
  if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      $comment = htmlspecialchars($row['comment'], ENT_QUOTES, 'utf-8');
      echo "<div class='original＿＿board'>";
      echo "<div><a href='./update.php?id=$row[id]'>編輯文章</a>";
      echo " <a href='./handle_delete.php?id=$row[id]'>刪除文章</a></div>";
      echo   "<div class='original＿＿createdAt'>留言時間：$row[created_at]</div>";
      echo   "<div class='original＿＿comment'>$comment</div>";
      echo "</div>";
    }
  } else {
    echo "<div><h3>你目前還沒有任何文章<a href='./index.php'>回到首頁</a>發些文章吧</h3></div>";
  }
}
// admin.php 的部份。

// handle_login.php 的部份
function generatorId(){
  $id_len = 32;//字串長度
  $id = '';
  $word = 'abcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()-=ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  //字典檔 可以將 數字 0 1 及字母 O L 排除
  $len = strlen($word);//取得字典檔長度
  for($i = 0; $i < $id_len; $i++){ //總共取 幾次
        $id .= $word[rand() % $len];//隨機取得一個字元
    }
  return $id;//回傳亂數 id
}

function cookieUpdate($conn, $cookie_id, $username) {
  $sql = "INSERT INTO `hugh_member_certificate`(`certificate_id`, `username`) 
    VALUES ('$cookie_id', '$username')";
  $result = $conn->query($sql);
  if (!$result) {
      echo 'failed, ' . $conn->error;
    }
}

function deleteOldCertificate($conn, $username) {
  $sql = "DELETE FROM hugh_member_certificate WHERE username = '$username'";
  $result = $conn->query($sql);
  if (!$result) {
      echo 'failed, ' . $conn->error;
    }
}
// handle_login.php 的部份

?>