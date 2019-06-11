/* eslint-disable no-use-before-define */
let onChangeTime = ''; // 先在上層定義，這樣才可以跨 function 使用
let onClickedTime = '';
let round = ''; // 當太早按下按鈕的時候，清除計時使用

function clickWhenColorChange() {
  onClickedTime = new Date().getTime(); // 記錄使用者點擊毫秒數
  const result = (onClickedTime - onChangeTime) / 1000; // 得到使用者變色到點擊的時間差
  alert(`你的成績是：${result}秒`);
  window.removeEventListener('click', clickWhenColorChange); // 取消自己的事件
  gameEnd();
} // 當顏色變了之後點擊，就會記錄點下的時間，然後減掉變色的時間，接著呈現結果

function colorChange() {
  window.removeEventListener('click', tooEarly); // 移除 tooEarly 事件
  onChangeTime = new Date().getTime(); // 記錄當前毫秒數
  document.querySelector('body').classList.add('body__change'); // 背景變色
  window.addEventListener('click', clickWhenColorChange); // 監測使用者的點擊
} // 變色之後的反應

function tooEarly() {
  clearTimeout(round);
  alert('太早了啦');
  window.removeEventListener('click', tooEarly); // 執行後取消自己的事件
  gameEnd();
} // 太早點擊的反應

function randomTime() {
  return (Math.random() * 2 + 1) * 1000;
} // 隨機時間 1 ~ 3 秒

function oneRound() {
  round = setTimeout(colorChange, randomTime());
  window.addEventListener('click', tooEarly); // 太早點下去的反應
} // 執行遊戲的 function

function gameEnd() {
  document.querySelector('button').classList.remove('btn');
  restart();
} // 遊戲結束， 取消隱藏再來一次按鈕

function restart() {
  document.querySelector('button').addEventListener('click', restartButton);
} // 註冊監聽再來一次的按鈕監聽

function restartButton(e) {
  document.querySelector('button').removeEventListener('click', restartButton); // 取消監聽，其實這段也許不用
  document.querySelector('body').classList.remove('body__change'); // 背景變回原色
  document.querySelector('button').classList.add('btn'); // 把按鈕隱藏
  oneRound(); // 重新執行遊戲
  e.stopPropagation(); // 停止把 click 事件冒泡上去
} // 重新開始遊戲的按鍵，還原預設值

oneRound(); // 執行遊戲的關鍵
