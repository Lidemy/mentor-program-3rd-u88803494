const request = new XMLHttpRequest();

function prizeResult(i) {
  const prizeContent = [{
    title: '恭喜你中頭獎了！日本東京來回雙人遊！',
    picture: './abroad.png',
    bodyChange: 'body--first',
  },
  {
    title: '二獎！90 吋電視一台！',
    picture: './lcd_tv.jpg',
    bodyChange: '',
    /* 這是要為 body 新增一個 class 用的，所以需要加上任何資料，不能為空會錯誤，所以直接給個隨意名稱。
    想請問除了這種作法還有更好的嗎？用判斷式就變得很多餘，也看起來較亂 */
  },
  {
    title: '恭喜你抽中三獎：知名 YouTuber 簽名握手會入場券一張，bang！',
    picture: './YouTube.png',
    bodyChange: '',
  },
  {
    title: '銘謝惠顧',
    picture: '', /* 這邊不給資料會變成 undefined，然後網頁會顯示圖片錯誤，所以使用空字串。 */
    bodyChange: 'body--none',
  }]; // 儲存得獎的恭喜詞與圖片路徑
  // 這邊是動態新增網頁的部分
  const container = document.querySelector('body');
  const div = document.createElement('div');
  if (prizeContent[i].bodyChange) { // 如果 bodyChange 有資料才執行
    container.classList.add(prizeContent[i].bodyChange);
  }
  div.classList.add('app');
  div.innerHTML = `
  <div class="app__prize">${prizeContent[i].title}</div>
  <div class="app__picture"><img src="${prizeContent[i].picture}"></div>`;
  container.appendChild(div);
}

function whichPrize(prize) {
  switch (prize) {
    case 'FIRST':
      prizeResult(0);
      break;
    case 'SECOND':
      prizeResult(1);
      break;
    case 'THIRD':
      prizeResult(2);
      break;
    case 'NONE':
      prizeResult(3);
      break;
    default:
      alert('系統不穩定，請再試一次');
  }
}

request.onload = () => {
  if (request.status >= 200 && request.status < 400) {
    const result = JSON.parse(request.responseText);
    whichPrize(result.prize); // 傳入抽中的值，判斷抽中哪個獎項
  } else {
    alert('系統不穩定，請再試一次');
  }
};

request.onerror = () => {
  alert('系統不穩定，請再試一次');
};
/* 有找到 ESlint 但其實看不太懂，個人猜測是因為易讀性。有找到只要改為 arrow function 就可以了 */

request.open('GET', 'https://dvwhnbka7d.execute-api.us-east-1.amazonaws.com/default/lottery', true);
request.send();
