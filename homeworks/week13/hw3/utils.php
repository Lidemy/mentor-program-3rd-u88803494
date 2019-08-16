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
function signedIn() {
  $nickname = htmlspecialchars($_SESSION['login_nickname'], ENT_QUOTES, 'utf-8');
  echo "<form action='./handle_add.php' method='post' class='new'>";
  echo    "<div><a href='./handle_signout.php'>登出</a>";
  echo    " <a href='./admin.php'>管理界面</a></div>";
  echo    "<div class='new__username'>暱稱：$nickname<input type='hidden' name='user_id' value='$_SESSION[login_id]'/></div>";
  // 寫這樣才可以隱藏資料，固定暱稱
  echo    "<div class='new__comment'><textarea name='comment' cols='70' rows='10'></textarea></div>";
  echo   "<input type='hidden' name='parent_id' value='0'>"; // 新增父留言屬性
  echo    "<div class='new__btn'><input type='submit' value='送出留言' /></div>";
  echo "</form>";
}

// 主/子留言功能
function comments($conn, $page, $per, $page_is, $login){
  $start = ($page-1)*$per;

  if($page_is === 'index.php') {
    $sql = 
      "SELECT C.comment, C.created_at, M.nickname, C.id AS parent_comment_id, C.user_id 
      FROM hugh_comments AS C LEFT JOIN hugh_member AS M ON C.user_id = M.id
      WHERE C.parent_id = 0 ORDER BY C.created_at DESC LIMIT $start, $per";
  } else if($page_is === 'admin.php') {
    $login_id = $_SESSION['login_id']; // 這樣之後才可以給 sql 使用
    $sql = 
      "SELECT C.id AS parent_comment_id, C.user_id, C.comment, M.nickname, C.created_at 
      FROM hugh_comments AS C LEFT JOIN hugh_member AS M on C.user_id = M.id 
      WHERE M.id = '$login_id' ORDER BY C.created_at DESC LIMIT $start, $per";
  } else {
    die('走錯地方');
  }

  $result = $conn->query($sql);
  if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
    while($row = $result->fetch_assoc()) {
      $nickname = htmlspecialchars($row['nickname'], ENT_QUOTES, 'utf-8');
      $comment = htmlspecialchars($row['comment'], ENT_QUOTES, 'utf-8');
      echo "<div class='original＿＿board'>";
      // 刪除/編輯的界面，分別傳入登入者 id 跟 comment 作者的 id，比對成功就顯示刪除編輯功能
      if ($login) echo memberInterface($row['user_id'], $row['parent_comment_id']);
      echo   "<div class='original＿＿nickname'>$nickname</div>";
      echo   "<div class='original＿＿createdAt'>留言時間：$row[created_at]</div>";
      echo   "<div class='original＿＿comment'>$comment</div>";
      
      if($login && $page_is === 'index.php') { // 改成有登入加上在首頁才顯示
        subCommentAdd($row['parent_comment_id']); 
        // 從伺服器上抓取下來的主留言 id(parent_comment_id) 直接傳入
        subComments($conn, $row['parent_comment_id'], $row['user_id'], $login); 
        // 傳入主留言的使用者 id(user_id)方便比對
      } else if ($page_is === 'index.php') { // 沒登入在首頁
        subComments($conn, $row['parent_comment_id'], $row['user_id'], $login); 
      }
      echo "</div>";
    }
  } else {
    echo "<div><h3>目前還沒有任何留言 <a href='./index.php'>回到首頁</a> 寫一些留言吧</h3></div>";
  }
}

// 子留言功能
function subComments($conn, $parent_id, $main_user_id, $login) { 
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
      if ($login) echo memberInterface($row['user_id'], $row['id']);
      echo     "<div class='original＿＿nickname'>$nickname</div>";
      echo     "<div class='original＿＿createdAt'>留言時間：$row[created_at]</div>";
      echo     "<div class='original＿＿comment'>$comment</div>";
      echo   "</div>";
    }
  }
}

function subCommentAdd($parent_id) {
  // 需要多傳入一個父留言 id，另傳入登入中使用者的 nickname 節省資源的撈取
  echo "<form action='./handle_add.php' method='post' class='original__sub-add'>";
  echo     "<div class='original＿＿nickname'>暱稱：$_SESSION[login_nickname]</div>";
  echo    "<input type='hidden' name='user_id' value=$_SESSION[login_id]/>";
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

function memberInterface($comment_user_id, $comment_id) {
  // 傳入留言作者 userid, 留言文章id
  // 當前使用者 id 改用 session 上的
  if ("$_SESSION[login_id]" === $comment_user_id) {
    return "<div><a href='./update.php?id=$comment_id'>編輯文章</a>
       <a href='./handle_delete.php?id=$comment_id'>刪除文章</a></div>";
  }
}
// index.php 的部份。

// admin.php 的部份。
function userInterface($conn) {
  $login_id = $_SESSION['login_id'];
  $sql = "SELECT * FROM hugh_member WHERE id = $login_id";
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

// admin.php 的部份。

?>