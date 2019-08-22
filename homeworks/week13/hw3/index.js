/* eslint-disable no-restricted-globals */
/* eslint-disable no-alert */
$(document).ready(() => {
  // $('input[type="submit"]').val('傳送中......').css('background', 'grey');
  // 好玩性質，可以在傳送時，變動按鈕的模樣。可以成功之後在變回來XD
  $('.original__nickname').on('click', '.member__delete', (e) => {
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

  $('.board').on('submit', 'form', (e) => {
    $.ajax({
      type: 'POST',
      url: './handle_add.php',
      data: $(e.target.closest('form')).serialize(), // 送出資料
      dataType: 'json',
      success: (res) => {
        if (res.id) {
          if (e.target.closest('.original__board')) {
            console.log(res);
            const result = `
              <div class='original__sub-comment $is_main'>
                <div class='original__nickname'>${res.nickname}
                  <div class='member__interface'>
                    <a class='member__edit' href='./update.php?${res.id}' data-id='${res.id}'>編輯</a>
                    <a class='member__delete' href='' data-id='${res.id}'>刪除</a>
                  </div>
                </div>
                <div class='original__comment'>${res.comment}</div>
                <div class='original__createdAt'>${res.created_at}</div>
              </div>`;
            $(e.target.closest('.original__board')).find('.original__sub-all').prepend(result);
            // 添加在最上面一個元素上面，這樣結果就跟伺服器渲染的一樣。

            // 添加完成之後要移除輸入框的內容
          }
        } else {
          alert(res.success);
        }
        // 成功之後就要 render 網頁了
      },
    });

    return false;
  });
  /*
  流程：
  1. 按下之後，從 submit 取得資料
  2. 發資料到 api 新增留言
  3. 接收 api 回應的成功與否，來決定要不要新增
  4. 正確的話就，根據正確的位置
  5. 把剛剛接收的資料印出
  */
});
