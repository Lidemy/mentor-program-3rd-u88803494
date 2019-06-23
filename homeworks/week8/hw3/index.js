const request = new XMLHttpRequest();
const container = document.querySelector('.board');
request.onload = function load() {
  if (request.status >= 200 && request.status < 400) {
    const response = request.responseText; // 可以取得資料，代表有通過驗證
    const json = JSON.parse(response);
    for (let i = 0; i < json.streams.length; i += 1) {
      const elements = document.createElement('a');
      elements.classList.add('twitch__block');
      elements.setAttribute('href', `${json.streams[i].channel.url}`);
      elements.setAttribute('target', '_blank');
      elements.innerHTML = `<div class="twitch__preview">
        <img src="${json.streams[i].preview.medium}"/>
        <div class="twitch__info">
          <img src="${json.streams[i].channel.logo}" class="twitch__logo"/>
          <div class="twitch__channel">
            <div class="twitch__status">${json.streams[i].channel.status}</div>
            <div class="twitch__name">${json.streams[i].channel.display_name} (${json.streams[i].channel.name})</div>
          </div>
        </div>
      </div>`;
      container.appendChild(elements);
    }
  } else {
    console.log('err');
  }
};

request.onerror = function error() {
  console.log('error');
};

request.open('GET', 'https://api.twitch.tv/kraken/streams/?game=League%20of%20Legends&limit=20&language=zh-tw', true);
request.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
request.setRequestHeader('Client-ID', '7jnow7dr6xs9f979a40a1rbd3rlim6');

request.send();

/*
curl -H 'Accept: application/vnd.twitchtv.v5+json' \
-H 'Client-ID: 7jnow7dr6xs9f979a40a1rbd3rlim6' \
-X GET 'https://api.twitch.tv/kraken/streams/?game=League%20of%20Legends&_limit=20'
*/
