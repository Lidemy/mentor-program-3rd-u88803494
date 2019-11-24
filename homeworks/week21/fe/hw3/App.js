import React from 'react';
import './App.css';

const Nav = ({ page, onClick }) => (
  <nav className="nav">
    <h1>BlOG</h1>
    <h3
      className={`nav__index ${page === 'index' && 'active'}`}
      onClick={() => onClick('index')}
    >
      首頁
    </h3>
    <h3
      className={`nav__about ${page === 'about' && 'active'}`}
      onClick={() => onClick('about')}
    >
      關於我
    </h3>
  </nav>
);

const About = () => (
  <div className="about">
    <h2 className="about__title">老師好我是網頁設計課的同學</h2>
    <dvi className="about__content">
      不不不，坐墊，諸位，不會吧，我們終於到了耶，這裡交給我們，別擔心，儘管如此，簡單又不花錢，Keroro，
      快趁現在，警察大人，才拼命研究的！

      請允許我，ㄟ那就結婚吧我沒有妳會死，前世的五百次回眸，但我可以肯定地告訴你，請允許我，我誰都不要，
      ㄟ那就結婚吧我沒有妳會死，ㄟ那就結婚吧我沒有妳會死，但我可以肯定地告訴你，我誰都不要，什麼都別說了，
      我誰都不要，請允許我，現在我不敢肯定，現在我不敢肯定，我們一輩子都來談戀愛吧！
    </dvi>
  </div>
);

class Blog extends React.Component {
  allPost = ({ data, onClick }) => (
    data.map(item => (
      <ul
        className="blog__title"
        key={item.id}
        onClick={() => onClick(item.id)}
      >
        {item.title}
      </ul>
    ))
  )

  post = (data, page) => (
    <div className="blog__post">
      <ul className="blog__title">{data[page - 1].title}</ul>
      <hr />
      <div className="blog__article">{data[page - 1].body}</div>
    </div>
  )

  render() {
    const { data, page } = this.props;
    return (
      <div className="blog">
        部落格文章
        <div className="blog__posts">
          {page === 'index'
            ? this.allPost(this.props) : this.post(data, page)}
        </div>
      </div>
    );
  }
}

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [],
      page: 'index',
    };
  }

  componentDidMount() {
    fetch('https://jsonplaceholder.typicode.com/posts')
      .then(res => res.json())
      .then((data) => {
        this.setState({
          data,
        });
      });
  }

  handleChangePage = (page) => {
    this.setState({
      page,
    });
  }

  handleGetPost = (id) => {
    this.setState({
      page: id,
    });
  }

  render() {
    const { page, data } = this.state;
    return (
      <div className="App">
        <Nav page={page} onClick={this.handleChangePage} />
        {/* 在這裡利用判斷看要顯示 blog 還是 about 的部分 */}
        {page === 'about' ? <About />
          : <Blog data={data} onClick={this.handleGetPost} page={page} />}
      </div>
    );
  }
}

export default App;
