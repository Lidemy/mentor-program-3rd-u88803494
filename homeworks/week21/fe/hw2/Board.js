import React from 'react';
import { boardSize } from './App';

const RenderPieces = ({ pieces, handleMove, movement }) => (
  <div className="game__pieces">
    <div
      className={`game__pieces--${pieces}`}
      onClick={() => handleMove(movement)}
    />
  </div>
);

class Board extends React.Component {
  render() {
    const squareValue = boardSize - 1;
    const renderBoard = Array(squareValue * squareValue).fill(null);
    const { squares, handleMove } = this.props;

    return (
      <div className="game__area">
        <div className="game__board">
          { // 下棋的部分
            squares
              .map((item, index) => (
                <RenderPieces
                  key={index}
                  handleMove={handleMove}
                  pieces={item}
                  movement={index}
                />
              ))
          }
        </div>
        <div className="game__lattice">
          { //  棋盤的部分
            renderBoard
              .map((_item, index) => (
                <div className="game__squares" key={index} />
              ))
          }
        </div>
      </div>
    );
  }
}

export default Board;
