const todolist = ['洗衣服', '曬衣服'];
function render() {
  $('.todolist__list').empty();
  function todolistItem(i) {
    return `
    <div class="todotlist__item form-check">
      <input class="todolist__done form-check-input" type="checkbox" value="" id="defaultCheck1">
      <label class="todolist__content form-check-label" for="defaultCheck1">
        ${todolist[i]}
      </label>
      <button type="button" class="todolist__delete btn btn-outline-secondary" data-id=${i}>刪除</button>
      <hr>
    </div>
  `;
  }
  for (let i = 0; i < todolist.length; i += 1) {
    $('.todolist__list').append(todolistItem(i));
  }
}

$(document).ready(() => {
  render();
  $('#input').keypress((e) => {
    const code = (e.keyCode ? e.keyCode : e.which);
    if (code === 13) {
      const input = $('#input').val(); // 從輸入框取得資料
      $('#input').val(''); // 清空輸入框
      todolist.push(input); // 添加資料
      render();
    }
  });

  // 刪除 事件代理
  $('.container').on('click', (e) => {
    if (e.target.classList.contains('todolist__delete')) {
      const id = e.target.getAttribute('data-id');
      todolist.splice(id, 1); // 移除對應的 id 資料
      render();
    }
  });
});
