let numberOperation = 0; // 儲存螢幕的數字
let inputNumber = 0; // 儲存輸入的數字
let operator = ''; // 儲存運算符號

function screenNumber(num) { // 在螢幕印出傳入值
  document.querySelector('.calculator__screen--output').innerText = num;
}

function changeToNumber(stringNumber) {
  let innerNumberOperation = numberOperation; // 要分開寫，免得汙染螢幕的數字
  innerNumberOperation += stringNumber;
  numberOperation = parseInt(innerNumberOperation, 10); // 轉換成數字
  screenNumber(numberOperation); // 把得到的數字覆蓋螢幕
} /* 這邊先把內部的數字跟外部的分開寫，理由是怕污染到螢幕的數字，但有可能不需要分開，
     之後再來評估看看。另外有個問題是，案太多下之後會突破螢幕寬度，這就留待以後再來處理 */

function equalUnit(num1, arithmetic, num2) {
  switch (arithmetic) {
    case '+':
      return num1 + num2;
    case '-':
      return num1 - num2;
    case '×':
      return num1 * num2;
    case '÷':
      return num1 / num2;
    default:
      return num2;
  }
}

function allClearUnut() { // AC 的單位，用全名來命名
  numberOperation = 0; // 重置所有的數值
  inputNumber = 0;
  operator = '';
  screenNumber(numberOperation);
} // 因為要遵守命名規則才這樣命名。想請問一下命名這邊改成 ACUnit 或是 acUnit 會是比較好的選擇嗎？

function inputClick(e) {
  if (e.target.classList.contains('calculator__input--nums')) {
    const stringNumber = e.target.innerText; // 抓取到的數字，不能在這邊轉成數字型態
    changeToNumber(stringNumber);
    /* 發現點號按鍵會有 bug，但是因為題目的要求沒有用到點號，所以就先不處理 */
  } else if (e.target.classList.contains('calculator__input--operator')) {
    operator = e.target.innerText; // 把點選的符號添加進運算符號
    inputNumber = numberOperation; // 也要把視窗的數字儲存起來
    numberOperation = 0; // 清空視窗的值, 這邊位置應該不正確，但卻可以成功執行
  } else if (e.target.classList.contains('calculator__input--equal')) {
    numberOperation = equalUnit(inputNumber, operator, numberOperation);
    screenNumber(numberOperation);
  } else if (e.target.classList.contains('calculator__input--AC')) {
    allClearUnut();
  }
}
/*
待解決問題：無法像一般的計算機那樣輸入123 += 之後會自動變成 123 + 123 的答案
也無法輸入 3 + 2 = 5 之後在案等於，就會變成原數值 +2 得 7
*/

document.querySelector('.calculator__input').addEventListener('click', inputClick);
