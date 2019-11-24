import React from 'react';
import './App.css';
import Board from './Board';

export const boardSize = 19;

// 計算勝負用
function calculateWinner(squares, x, y) {
  if (x === null || y === null) {
    return null;
  }

  // 轉化成二維陣列
  const boardCoordinates = [];
  for (let i = 0; i < boardSize; i += 1) {
    const start = i * boardSize;
    const end = start + boardSize;
    boardCoordinates.push(squares.slice(start, end));
  }

  const currentPieces = boardCoordinates[y][x]; // 取得當前顏色

  function checkLine(currentX, currentY, directionX, directionY) {
    let nextX = currentX;
    let nextY = currentY;
    let lineLength = 0;

    do {
      nextX += directionX;
      nextY += directionY;

      if (
        nextX >= 0 && nextX < boardSize
        && nextY >= 0 && nextY < boardSize
        && boardCoordinates[nextY][nextX] === currentPieces
      ) {
        lineLength += 1;
      } else {
        break;
      }
    } while (lineLength);
    return lineLength;
  }

  // 計算不含自己有沒有超過四個子
  if (
    checkLine(x, y, 1, 0) + checkLine(x, y, -1, 0) >= 4
    || checkLine(x, y, 0, 1) + checkLine(x, y, 0, -1) >= 4
    || checkLine(x, y, 1, 1) + checkLine(x, y, -1, -1) >= 4
    || checkLine(x, y, 1, -1) + checkLine(x, y, -1, 1) >= 4
  ) {
    return currentPieces;
  }
  return null;
}

const Information = ({ status }) => (
  <div className="game__info">
    <h1 className="game__title">五子棋</h1>
    <h3 className="game__state">{status}</h3>
  </div>
);

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      squares: Array(boardSize * boardSize).fill(null),
      blackIsNext: true,
      currentX: null,
      currentY: null,
    };
  }

  handleMove = (movement) => {
    const {
      squares, blackIsNext, currentX, currentY,
    } = this.state;

    if (calculateWinner(squares, currentX, currentY) || squares[movement]) {
      return;
    }

    squares[movement] = blackIsNext ? 'black' : 'white';
    this.setState({
      squares,
      blackIsNext: !blackIsNext,
      currentX: movement % boardSize,
      currentY: Math.floor(movement / boardSize),
    });
  }

  render() {
    const {
      squares, blackIsNext, currentX, currentY,
    } = this.state;
    const winner = calculateWinner(squares, currentX, currentY);

    let status;
    if (winner) {
      status = `Winner: ${winner}`;
    } else {
      status = `next: ${blackIsNext ? 'black' : 'white'}`;
    }

    return (
      <div className="game container">
        <Information status={status} />
        <Board squares={squares} handleMove={this.handleMove} />
      </div>
    );
  }
}

export default App;
