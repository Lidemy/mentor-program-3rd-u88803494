/* 測試的資料，不捨得刪 XD
function test() {
  const email = document.querySelector('#email').value;
  alert(`你的eamil是 ${email}`);
  const nickname = document.querySelector('#nickname').value;
  alert(`你的nickname是 ${nickname}`);
  const engineer = document.getElementsByName('choose-one');
  alert(`你不是工程師 ${engineer[0].checked}`);
  alert(`你是工程師 ${engineer[1].checked}`); // 用迴圈跑就可以得到哪個有被勾選
  const job = document.querySelector('#job ').value;
  alert(`你的職業是是 ${job}`);
  const how = document.querySelector('#how').value;
  alert(`你怎麼知道的 ${how}`);
  const learned = document.querySelector('#learned').value;
  alert(`學過嗎？ ${learned}`);
  const elseToTalk = document.querySelector('#else').value;
  alert(`其他要說的嗎？ ${elseToTalk}`);
}
let a = '123@123';
a = 'abc@a.com';
data.email = a;
data.abc = 3;
console.log(`你的 email 是 ${data.email}`);
console.log(`你的 email 是 ${data.abc}`);
if (data.type === '') {
  console.log(data);
}
*/

const data = { // 存放表單資料用
  email: '',
  nickname: '',
  type: '',
  job: '',
  how: '',
  learned: '',
  else: '',
};

const formContentRequired = document.querySelectorAll('.form__content--required');
const formContent = document.querySelectorAll('.form__content');
// 選取必用的 class，預先寫出來 function 就不用每次都要宣告

function success() { // 成功之後在 console 印出資料
  const finalData = `email： ${data.email}
暱稱： ${data.nickname}
報名類型： ${data.type}
現在職業： ${data.job}
怎麼知道這個計畫的？ ${data.how}
是否有程式相關經驗？ ${data.learned}
其他要說的是: ${data.else}`;
  console.log(finalData);
  alert('成功提交');
} // 發現可以確實印出資料，但是瞬間就消失了。這是 from 的特性嗎？


function elseData() { // 其他資料 function
  const elseValue = document.querySelector('#else').value;
  data.else = elseValue;
  success(); // 成功才可以執行
}

/* 偵測部分 */
function remind(i) { // 提醒的添加 function
  formContentRequired[i].classList.remove('form__content--none'); // 無值則消去隱藏的 css
  formContent[i].classList.add('form__content--background'); // 然後背景添加顏色
}

function learnedVerification(e) { // 偵測是否有相關背景
  const learnedValue = document.querySelector('#learned').value;
  if (learnedValue === '') {
    remind(5, learnedValue); // 嘗試添加資料
    e.preventDefault();
  } else {
    data.learned = learnedValue; // 添加資料
    elseData();
  }
}

function howVerification(e) { // 偵測你怎麼知道
  const howValue = document.querySelector('#how').value;
  if (howValue === '') {
    remind(4);
    e.preventDefault();
  } else {
    data.how = howValue;
  }
  learnedVerification(e);
}

function jobVerification(e) { // 偵測現在職業
  const jobValue = document.querySelector('#job').value;
  if (jobValue === '') {
    remind(3);
    e.preventDefault();
  } else {
    data.job = jobValue;
  }
  howVerification(e);
}


function whichOne() { // 判斷報名類型是哪一種
  const engineer = document.getElementsByName('choose-one');
  if (engineer[0].checked) {
    return '從零到一基礎班';
  } // 在 typeVerification 已經判斷過了，所以不是第一個就是第二個，這邊就不再判斷一次了
  return '在職工程師加強班';
}

function typeVerification(e) { // 偵測報名類型
  const typeValue = document.getElementsByName('choose-one');
  if (!typeValue[0].checked && !typeValue[1].checked) { // 兩邊都是 false 所以要這樣判斷
    remind(2);
    e.preventDefault();
  } else {
    data.type = whichOne(); // 要另外判斷
  }
  jobVerification(e);
}

function nicknameVerification(e) { // 偵測暱稱
  const nicknameValue = document.querySelector('#nickname').value;
  if (nicknameValue === '') {
    remind(1);
    e.preventDefault();
  } else {
    data.nickname = nicknameValue;
  }
  typeVerification(e);
}

function emailVerification(e) { // 偵測 email
  const emailValue = document.querySelector('#email').value;// 偵測 email 有沒有值
  if (emailValue === '') {
    remind(0);
    e.preventDefault();
  } else {
    data.email = emailValue;
  }
  nicknameVerification(e);
}


const btn = document.querySelector('.form__content--submit');
btn.addEventListener('click', emailVerification);
