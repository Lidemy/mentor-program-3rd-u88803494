function reverse(str) {
  let newStr = [];
  newStr = str.split('');
  const changedStr = [];
  for (let i = 0; i < (str.length); i += 1) {
    let arrnum = 0;
    arrnum = str.length - 1 - i;
    changedStr[i] = str[arrnum];
  }
  newStr = changedStr.join('');
  return newStr;
}

console.log(reverse('go sell matches'));
