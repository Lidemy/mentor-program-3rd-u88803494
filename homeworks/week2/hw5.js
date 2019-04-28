function join(str, concatStr) {
  let newStr = '';
  for (let i = 0; i < str.length; i += 1) {
    if (i < (str.length - 1)) {
      newStr = newStr + str[i] + concatStr;
    } else {
      newStr += str[i];
    }
  }
  return newStr;
}

function repeat(str, times) {
  let newStr = '';
  for (let i = 0; i < times; i += 1) {
    newStr += str;
  }
  return newStr;
}

console.log(join(['a', 'b', 'c'], '!'));
console.log(repeat('ia', 15));
