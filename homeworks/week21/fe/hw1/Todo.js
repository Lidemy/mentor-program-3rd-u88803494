import React from 'react';

export class Todo extends React.Component {
  delete = () => {
    const { todo, deleteTodo } = this.props;
    deleteTodo(todo.id);
  };

  editing = () => {
    // if(e.target.className.indexOf('edit')) {alert('有惹')}
    // 思考之後可以用這個判斷來把 function 功能寫在一起
    const { editTodo, todo } = this.props;
    editTodo(todo.id, todo.content);
  };

  mark = () => {
    const { todo, markTodo } = this.props;
    markTodo(todo.id);
  };

  render() {
    const { todo } = this.props;
    return (
      <div className="todotlist__item form-check">
        <input
          className="todolist__done form-check-input"
          type="checkbox"
          name="done"
          checked={todo.isCompleted}
          onChange={this.mark}
        />
        <label className="todolist__content form-check-label">
          {todo.content}
        </label>
        <button
          type="button"
          className="todolist__edit btn btn-outline-secondary"
          onClick={this.editing}
        >
          編輯
        </button>
        <button
          type="button"
          className="todolist__delete btn btn-outline-secondary"
          onClick={this.delete}
        >
          刪除
        </button>
        <hr />
      </div>
    );
  }
}
