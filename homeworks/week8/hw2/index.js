
const request = new XMLHttpRequest();

function messageData() {
  request.open('GET', 'https://lidemy-book-store.herokuapp.com/posts?_limit=20&_sort=id&_order=desc', true);
  request.send();
} /* 試著做出送出資料後就把新留言同步上去，所以額外把發送命令打包。
但發現這樣做其實有點難度，可能還要先清掉原本的資料，之後再把新資料弄上去。
而且也發現會發生一些問題，在於資料上傳沒這麼快，所以一樣會遇到等待的問題，所以直接寫在送出的後面，會導致沒辦法撈到最新的資料。
而且似乎會傳不上去？應該是因為有兩個 request 的關係吧？
這部分感覺難度未明 */

function post(message) {
  const obj = {
    content: '',
  };
  obj.content = message;
  const uploadDate = JSON.stringify(obj); // 轉換成 json 格式
  request.open('POST', 'https://lidemy-book-store.herokuapp.com/posts', true);
  request.setRequestHeader('Content-type', 'application/json'); // 必須要加上才可以，用意應該是要分辨資料是哪一種
  request.send(uploadDate);
}

document.querySelector('.new__btn').addEventListener('click', () => {
  const message = document.querySelector('.new__input').value; // 選取輸入框並得到輸入了甚麼
  post(message);
});

const container = document.querySelector('.original');
request.onload = function load() {
  if (request.status >= 200 && request.status < 400) {
    const response = request.responseText;
    const json = JSON.parse(response);
    for (let i = 0; i < json.length; i += 1) {
      const div = document.createElement('div');
      div.classList.add('original__content');
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

messageData();
