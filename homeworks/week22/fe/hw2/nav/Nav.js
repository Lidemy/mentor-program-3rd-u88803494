import React from 'react';
import './Nav.css';
import { Link, Route } from "react-router-dom";

const Item = ({ to, text, exact }) => (
  <Route
    path={to}
    exact={exact}
    children={({ match }) => (
      <Link to={to}>
        <li className={match ? "active" : ""}>
          {text}
        </li>
      </Link>
    )}
  />
);

const Nav = ({ page, onClick }) => (
  <nav className="nav">
    <header><h1>BlOG</h1></header>
    <Item to='/' exact={true} text='首頁' />
    <Item to='/posts' text='文章列表' />
    <Item to='/about' text='關於我' />
  </nav>
);


export default Nav;
