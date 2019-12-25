import React, { Component } from 'react';
import './home.css';

const style = {
  homepage: {
    fontSize: '40px',
    paddingTop: '10px',
  }
}

class Home extends Component {
  render() {
    return (
      <div className="home">
        <div style={style.homppage}>I am homepage</div>
      </div>
    );

  }
}

export default Home;
