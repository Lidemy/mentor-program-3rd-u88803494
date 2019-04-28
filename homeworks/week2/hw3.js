function reverse(str) {
  let NewStr = [];
  NewStr = str.split('');
  const changedStr = [];
  for (let i = 0; i < (str.length); i += 1) {
    let arrnum = 0;
    arrnum = str.length - 1 - i;
    changedStr[i] = str[arrnum];
  }
  NewStr = changedStr.join('');
  return NewStr;
}

console.log(reverse('go sell matches'));
