/* eslint-disable no-restricted-globals */
/* eslint-disable no-alert */
$(document).ready(() => {
  // 刪除功能
  $('.original__main-all').on('click', '.member__delete', (e) => {
    if (!confirm('是否要刪除？')) return false; // 不刪除則跳出
    const id = $(e.target).attr('data-id');
    $.ajax({
      url: `./handle_delete.php?id=${id}`, // 傳送資料
      success: (res) => {
        const result = JSON.parse(res);
        if (result.success === 'true') {
          if (e.target.closest('.original__sub-comment')) {
            // 如果有找到就移除子留言
            $(e.target.closest('.original__sub-comment')).fadeOut(500);
          } else if (e.target.closest('.original__board')) {
            $(e.target.closest('.original__board')).fadeOut(500);
          }
        } else {
          alert(result.success);
        }
      },
    });
    return false; // 使 a 元素不能換頁
  });

  // 新增留言功能
  $('.board').on('submit', 'form', (e) => {
    // 偵測有無空值，空值就不給送出並提示
    if ($(e.target.closest('form')).find('textarea').val() === '') {
      const renderTarget = $(e.target.closest('form')).find('textarea');
      renderTarget.attr('placeholder', '內容不可以為空');
      for (let i = 0; i <= 5; i += 1) { // 震動視窗
        renderTarget.animate({ 'margin-left': '-10px' }, 50).animate({ 'margin-left': '10px' }, 50);
      }
      renderTarget.animate({ 'margin-left': '0px' }, 50);
      return false;
    }

    $.ajax({
      type: 'POST',
      url: './handle_add.php',
      data: $(e.target.closest('form')).serialize(), // 送出資料
      dataType: 'json', // 這邊打 json 格式就會自動轉換
      success: (res) => {
        if (res.id) {
          // 子留言的部份處理
          if (e.target.closest('.original__board')) {
            const result = `
            <div class='original__sub-comment ${res.is_main}'>
              <div class='original__nickname'>${res.nickname}
                <div class='member__interface'>
                  <a class='member__edit' href='./update.php?id=${res.id}' data-id='${res.id}'>編輯</a>
                  <a class='member__delete' href='' data-id=${res.id}>刪除</a>
                </div>
              </div>
              <div class='original__comment'>${res.comment}</div>
              <div class='original__createdAt'>${res.created_at}</div>
            </div>`;

            $(e.target.closest('.original__board')).find('.original__sub-all')
              .prepend($(result).hide().fadeIn(500)); // 這樣寫才會只有添加的部份有特效
            // 添加在最上面一個元素上面，這樣結果就跟伺服器渲染的一樣。

            // 清空相對應的 textarea
            $(e.target.closest('form')).find('textarea').val('');

            // 添加完成之後要移除輸入框的內容
            return false; // 加了這行才不會執行完之後又繼續執行下方
          }

          // 主留言
          if (e.target.closest('.board')) {
            if (location.search && location.search !== '?page=1') {
              alert('留言已送出，請到首頁或管理界面觀看留言');
              return false;
            }
            // 除了第一頁之外，新增留言，就不渲染出來
            const result = `
            <div class='original__board'>
              <div class='original__main original__main-bgcolor'>
                <div class='original__nickname'>${res.nickname}
                  <div class='member__interface'>
                    <a class='member__edit' href='./update.php?id=${res.id}' data-id='${res.id}'>編輯</a>
                    <a class='member__delete' href='' data-id=${res.id}>刪除</a>
                  </div>
                </div>
                <div class='original__comment'>${res.comment}</div>
                <div class='original__createdAt'>${res.created_at}</div>
              </div>
              <form action='./handle_add.php' method='post' class='original__sub-add new'>
                <div class='original__nickname'>暱稱：${res.session.login_nickname}</div>
                <input type='hidden' name='user_id' value='${res.session.login_id}' />
                <div class='new__comment'><textarea name='comment' rows='3' placeholder='請輸入留言'></textarea></div>
                <input type='hidden' name='parent_id' value='${res.id}' />
                <div class='new__btn'><input type='submit' value='送出留言' /></div>
              </form>
              <div class='original__sub-all'></div>
            </div>`;

            $(e.target.closest('.board')).find('.original__main-all')
              .prepend($(result).hide().fadeIn(500));

            // 清空相對應的 textarea
            $(e.target.closest('form')).find('textarea').val('');

            return false; // 加了這行才不會執行完之後又繼續執行下方
          }
        } else {
          alert(res.success);
        }
        return false;
      },
    });
    return false; // 避免網頁轉跳
  });
});
