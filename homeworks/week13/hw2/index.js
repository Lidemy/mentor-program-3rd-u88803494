$(document).ready(() => {
  $('#input').keypress((e) => {
    const code = (e.keyCode ? e.keyCode : e.which);
    if (code === 13) {
      const input = $('#input').val(); // 取得資料
      $('#input').val(''); // 清空資料
      // 後續是取得輸入的資料之後，直接顯示在下方
      const result = `
      <div class="todotlist__item form-check">
        <input class="todolist__done form-check-input" type="checkbox" value="" id="defaultCheck1">
        <label class="todolist__content form-check-label" for="defaultCheck1">
          ${input}
        </label>
        <button type="button" class="todolist__delete btn btn-outline-secondary">刪除</button>
        <hr>
      </div>`;
      $('.todolist__input').append(result);
    }
  });

  // 刪除 事件代理
  $('.container').on('click', (e) => {
    if (e.target.classList.contains('todolist__delete')) {
      $(e.target.closest('.todotlist__item')).remove();
    }
  });
});
