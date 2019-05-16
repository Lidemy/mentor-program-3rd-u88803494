const request = require('request');

request('https://lidemy-book-store.herokuapp.com/books?_limit=10', (_error, _response, body) => {
  console.log(body);
});
