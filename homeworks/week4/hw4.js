const request = require('request');
// 題目要求要直接輸出所需要的結果

const options = {
  url: 'https://api.twitch.tv/helix/games/top',
  headers: {
    'Client-ID': '7jnow7dr6xs9f979a40a1rbd3rlim6',
  },
};

function callback(error, response, body) {
  if (!error && response.statusCode === 200) {
    const info = JSON.parse(body);
    for (let i = 0; i < info.data.length; i += 1) {
      console.log(info.data[i].id, info.data[i].name);
    }
  }
}

request(options, callback);
