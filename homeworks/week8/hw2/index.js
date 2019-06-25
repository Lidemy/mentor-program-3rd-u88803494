function messageData() {
  const request = new XMLHttpRequest();
  request.open('GET', 'https://lidemy-book-store.herokuapp.com/posts?_limit=20&_sort=id&_order=desc', true);
  request.send();
  const container = document.querySelector('.message__box');
  request.onload = function load() {
    if (request.status >= 200 && request.status < 400) {
      const response = request.responseText;
      const json = JSON.parse(response);
      for (let i = 0; i < json.length; i += 1) {
        const div = document.createElement('div');
        div.classList.add('message__content');
        div.innerHTML = json[i].content;
        container.appendChild(div);
      }
    } else {
      console.log('err');
    }
  };

  request.onerror = function error() {
    console.log('error');
  };
}

function post(message) {
  document.querySelector('.new__input').value = ''; // 清空輸入框資料
  const request = new XMLHttpRequest();
  const obj = {
    content: '',
  };
  obj.content = message;
  const uploadDate = JSON.stringify(obj); // 轉換成 json 格式
  /* 自己發現一個 bug ，如果上傳的資料是 html 標籤及 class 就會被當成是標籤，而不是純文字
  即使用了 encodeURIComponent() 也一樣會有 bug，
  另外想請問老師我這邊自己把他轉成 JSON 的動作是否跟 encodeURIComponent() 是一樣的操作呢？
  */
  request.open('POST', 'https://lidemy-book-store.herokuapp.com/posts', false); // 改成同步
  request.setRequestHeader('Content-type', 'application/json'); // 必須要加上才可以，用意應該是要分辨資料是哪一種
  request.send(uploadDate);
  document.querySelector('.message__box').innerHTML = ''; // 清除原本的資料
  messageData();
  /*
  1. 試著移除 class，現在是測試有沒有辦法一次選中全部之後移除，或是直接在最上層添加。
  也發現動態新增的選不到? NodeList 是顯示空，思考之後應該是因為 JavaScript 新增的並沒有被算進 DOM 裡面吧？
  看了同學的作業才知道直接 innerHTML 清空就好了。我到底這在幹嘛QQ
  另外想把留言直接新增上去，不想再次跟伺服器請求資源。但如果要這樣作好像也不太行，因為要清空 html
  2. 發現不能在輸入框跟按鈕使用 form 標籤，用的話送出會重新整理。使用 form 的話是因為希望可以送出清空輸入框資料
  */
}

document.querySelector('.new__btn').addEventListener('click', () => {
  const message = document.querySelector('.new__input').value; // 選取輸入框並得到輸入了甚麼
  post(message);
});

messageData();
