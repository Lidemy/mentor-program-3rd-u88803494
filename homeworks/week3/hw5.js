

function zeroPadding(arr, n) {
  for (let i = 1; i <= n; i += 1) {
    arr.push('0');
  }
  return arr;
}

function littleAdd(a, b, c = '0') { // c 是進位
  const newA = parseInt(a, 10); // 轉換成數字
  const newB = parseInt(b, 10);
  const newC = parseInt(c, 10);
  return `${newA + newB + newC}`; // 相加後回傳字串
}

function carryProcessing(str) {
  return str[1];
}

function longerLength(a, b) { // 回傳較長的陣列長度
  if (a.length >= b.length) { // 找出誰比較長，用較長者作迴圈次數計算
    return a.length;
  }
  return b.length;
} // 得到最長的字串長度，以及兩數修為一樣長的陣列

function add(a, b) {
  const arrA = a.split('').reverse(); // 切成陣列且反轉
  const arrB = b.split('').reverse();
  const length = longerLength(a, b);
  if (a.length >= b.length) { // 找出誰比較長，用較長者作迴圈次數計算
    zeroPadding(arrB, (length - b.length)); // 把另外一邊補零
  } else {
    zeroPadding(arrA, (length - a.length));
  } // 得到最長的字串長度，以及兩數修為一樣長的陣列
  let result = ''; // 回傳結果的變數
  let carryNum = '0'; // 進位用的變數
  for (let i = 0; i < length; i += 1) { // 計算值
    if (littleAdd(arrA[i], arrB[i], carryNum) < 10) { // 判斷有無進位
      result = littleAdd(arrA[i], arrB[i], carryNum) + result;
      carryNum = '0'; // 無進位改為 0
    } else { // 進位處理
      result = carryProcessing(littleAdd(arrA[i], arrB[i], carryNum)) + result;
      carryNum = '1'; // 這要下一輪才能使用
    }
    if (i === length - 1 && carryNum === '1') { // 只判斷最後一位數需不需要進位
      result = carryNum + result;
    }
  }
  return result;
}
console.log(add('12312383813881381381', '129018313819319831'));
module.exports = add;
