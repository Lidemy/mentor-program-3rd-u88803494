function reverse(str) {
  let NewStr = [];
  NewStr = str.split('');
  const changedStr = []; // 思考系統為什麼一直強迫我用 const 發現是因為陣列是定址記憶體位置，但這樣的話是不是就屬於誤判了
  for (let i = 0; i < (str.length); i += 1) {
    let arrnum = 0;
    arrnum = str.length - 1 - i;
    changedStr[i] = str[arrnum];
  }
  NewStr = changedStr.join('');
  return NewStr;
}

console.log(reverse('go sell matches'));
