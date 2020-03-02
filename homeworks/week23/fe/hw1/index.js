/* eslint-disable react/jsx-filename-extension */
/* eslint-disable import/no-unresolved */
import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import { Provider } from 'react-redux';
import { createStore, combineReducers } from 'redux';
import App from './App';
import * as serviceWorker from './serviceWorker';
import { postsReducer, wnidowReducer } from './reducer';

const reducers = combineReducers({
  posts: postsReducer,
  showWindowData: wnidowReducer,
});

const store = createStore(reducers);

ReactDOM.render(
  <Provider store={store}>
    <App name="hugh" />
  </Provider>, document.getElementById('root'),
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
