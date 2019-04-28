function capitalize(str) {
  let arr = [];
  arr = str.split(''); // 把 str 拆成陣列
  let NewStr = [];
  if (arr[0] >= 'a' && arr[0] <= 'z') { // 判斷是否是小寫
    arr[0] = arr[0].toUpperCase();
  }
  NewStr = arr.join('');
  return NewStr;
}

console.log(capitalize('hello world'));
