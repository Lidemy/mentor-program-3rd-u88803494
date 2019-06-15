let numberOperation = 0; // 儲存螢幕的數字
let inputNumber = 0; // 儲存輸入的數字
let inputNumber2 = 0; // 儲存輸入的數字
let operator = ''; // 儲存運算符號


function screenNumber2(num) { // 在螢幕印出傳入值
  document.querySelector('.calculator__screen--output').innerText = num;
}

function screenNumber(num) { // 要變更名字，想清楚用途
  let innerNumberOperation = inputNumber; // 要分開寫，免得汙染螢幕的數字
  innerNumberOperation += num;
  inputNumber = parseInt(innerNumberOperation, 10); // 轉換成數字
  screenNumber2(inputNumber);
  // 把得到的數字覆蓋螢幕
} /* 這邊先把內部的數字跟外部的分開寫，理由是怕污染到螢幕的數字，但有可能不需要分開，
     之後再來評估看看。另外有個問題是，案太多下之後會突破螢幕寬度，這就留待以後再來處理 */

function equalUnit(num1, Arithmetic, num2) {
  switch (Arithmetic) {
    case '+':
      return num1 + num2;
    case '-':
      return num1 - num2;
    case '×':
      return num1 * num2;
    case '÷':
      return num1 / num2;
    default:
      return '';
  }
}

/*
function allClearUnut() { // AC 的單位，命名這邊改成 ACUnit 或是 acUnit 會是比較好的選擇嗎？

}
*/

function inputClick(e) {
  if (e.target.classList.contains('calculator__input--nums')) {
    const nums = e.target.innerText; // 抓取到是哪個數字，不能在這邊轉成數字型態
    screenNumber(nums);
    /* 發現點號按鍵會有 bug，但是因為題目的要求沒有用到點號，所以就先不處理 */
  } else if (e.target.classList.contains('calculator__input--operator')) {
    operator = e.target.innerText; // 把點選的符號添加進運算符號
    inputNumber2 = inputNumber; // 先偷個懶
    inputNumber = 0; // 清空, 這邊位置不正確
  } else if (e.target.classList.contains('calculator__input--equal')) {
    numberOperation = equalUnit(inputNumber2, operator, inputNumber);
    screenNumber2(numberOperation);
  } else if (e.target.classList.contains('calculator__input--AC')) {
    const AC = e.target.innerText;
    console.log(AC); // 一樣先用印出替代
  }
} // 應該先想辦法讓數字可以累加

document.querySelector('.calculator__input').addEventListener('click', inputClick);
