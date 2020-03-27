import React from 'react';
import {
  Button, Figure, Card, CardGroup,
} from 'react-bootstrap';
import './home.css';


const SeeMoreButton = ({ className, text, variant }) => (
  <Button variant={variant} href="#/posts" className={className}>
    {text}
  </Button>
);

const Advantages = ({ avaData }) => (
  <CardGroup>
    {avaData.map(data => (
      <Card key={data.url}>
        <Card.Img variant="top" src={data.url} />
        <Card.Body>
          <Card.Title>{data.title}</Card.Title>
          <Card.Text>
            {data.text}
          </Card.Text>
        </Card.Body>
        <Card.Footer>
          <small className="text-muted">
            {' '}
            {data.footer}
            {' '}
          </small>
        </Card.Footer>
      </Card>
    ))}
  </CardGroup>
);

const Home = () => {
  const avaData = [
    {
      url: 'https://i.imgur.com/YK1x04c.png',
      title: '文章功能',
      text: '可以新增、刪除、編輯文章',
      footer: '更好',
    },
    {
      url: 'https://i.imgur.com/vqvtTgW.png',
      title: '特效',
      text: '一點點的特效',
      footer: '好還要更好',
    },
    {
      url: 'https://i.imgur.com/ze7iutQ.png',
      title: '不讀檔',
      text: '網站換頁不讀檔',
      footer: '更棒了',
    },
  ];
  return (
    <div className="homepage">
      <header className="homepage__header">
        <div className="homepage__header--title">這就是部落格</div>
        <div className="homepage__header--subtitle">this is my blog</div>
        <SeeMoreButton
          className="homepage__header--btn"
          text="現在就立刻看更多"
          variant="danger"
        />
      </header>
      <hr />
      <main className="homepage__main">
        <div className="main__askwhy">
          <strong className="main__askwhy--content mobile__fontsize">
            <li>你想要寫 BLOG 卻沒地方去？</li>
            <li>簡單的特效就好，但是市面上的 blog 都很複雜</li>
            <li>想回到那個美好純真的年代嗎？</li>
            <li>回歸部落格的本質想寫什麼就寫什麼？</li>
          </strong>
        </div>
        <div className="main__advantages">
          <Advantages avaData={avaData} />
          <div className="main__advantages--btn">
            <SeeMoreButton
              className="homepage__header--btn"
              text="現在就立刻看更多"
              variant="outline-dark"
            />
          </div>
        </div>
        <hr />
        <div className="main__CTA">
          <pre className="main__CTA--text mobile__fontsize">
            {`
              寫文章最注重的是什麼？
              不就是表達出自己內心中想寫的內容就好。
              就好像一顆大樹，靜靜的吸收養分，
              然後散發你的靈性，發揮你的淺能。
              寫吧！孩子
              `}
          </pre>
          <Figure>
            <Figure.Image
              width={1920}
              height={1080}
              alt="1920X1080"
              src="https://i.imgur.com/Pl30j07.jpg"
            />
            <Figure.Caption>
              安安靜靜地生長於天地之間，從從容容地經歷著春夏秋冬。一季又一季，一年又一年……不像鮮花那樣嬌貴，從來不懼風吹雨淋。大樹依然屹立，藤蔓永訴纏綿……
            </Figure.Caption>
          </Figure>
          <div className="main__CTA-btn">
            <SeeMoreButton
              className="homepage__header--btn"
              text="立刻就去寫文章"
              variant="outline-dark"
            />
          </div>
        </div>
      </main>
    </div>
  );
};


export default Home;
