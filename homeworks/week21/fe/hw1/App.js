import React from 'react';
import './App.css';
import { Todo } from './Todo';
import { Editing, Processing } from './Utils';

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      todos: [],
      todoText: '',
      editingTodo: {},
      isEditing: false,
      isProcessing: false,
    };
    this.id = 1;
  }

  componentDidMount() {
    const todoData = window.localStorage.getItem('todoapp');
    if (todoData) { // 為了要保持狀態，所以這樣直接判斷
      const oldData = JSON.parse(todoData);
      this.setState({
        ...oldData,
      });
      this.id = oldData.todos.length !== 0
        ? oldData.todos[oldData.todos.length - 1].id + 1 : 1;
      // 避免當資料全部刪除之後的無法 render
    }
  }

  componentDidUpdate(_prevProps, prevState) { // 試著寫會還原狀態的 app
    if (prevState !== this.state) {
      window.localStorage.setItem('todoapp',
        JSON.stringify(this.state));
    }
  }

  handleChange = (e) => {
    this.setState({
      todoText: e.target.value,
    });
  }

  handleEditingChange = (text) => {
    // 從傳入的改變，id 直接取暫存區的即可。
    const { editingTodo } = this.state;
    this.setState({
      editingTodo: {
        ...editingTodo,
        text,
      },
    });
  }

  handleSubmit = (e) => {
    const { todos, todoText } = this.state;
    if (e.key === 'Enter') {
      this.setState({
        todos: [...todos, {
          id: this.id,
          isCompleted: false,
          content: todoText,
        }],
        todoText: '',
      });
      this.id += 1;
    }
  }

  handleUpdate = () => {
    const { editingTodo, todos } = this.state;
    this.setState({
      todos: todos.map((todo) => {
        if (todo.id !== editingTodo.id) return todo;
        return {
          ...todo,
          content: editingTodo.text,
        };
      }),
      isEditing: false,
      isProcessing: false,
      editingTodo: {},
    });
  };

  deleteTodo = (id) => {
    const { todos } = this.state;
    this.setState({
      todos: todos.filter(todo => todo.id !== id),
    });
  };

  editTodo = (id, content) => {
    this.setState({
      editingTodo: { id, text: content },
      isEditing: true,
      isProcessing: true,
    });
  };

  cancelEdit = () => {
    this.setState({
      isEditing: false,
      isProcessing: false,
    });
  };

  markTodo = (id) => {
    const { todos } = this.state;
    this.setState({
      todos: todos.map((todo) => {
        if (todo.id !== id) return todo;
        return {
          ...todo,
          isCompleted: !todo.isCompleted,
        }; // 只把不同 id 的部份做相反的處理
      }),
    });
  };

  render() {
    const {
      todos, todoText, isEditing, isProcessing, editingTodo,
    } = this.state;
    return (
      <div className="App container">
        <div className="todolist__input">
          <h1> todolist </h1>
          <input
            className="form-control form-control-sm"
            id="input"
            type="text"
            placeholder="輸入代辦事項 輸入完成按下 enter 送出"
            onChange={this.handleChange}
            value={todoText}
            onKeyPress={this.handleSubmit}
          />
          <hr />
        </div>
        <div className="todolist__list">
          {todos.map(todo => (
            <Todo
              todo={todo}
              key={todo.id}
              deleteTodo={this.deleteTodo}
              markTodo={this.markTodo}
              editTodo={this.editTodo}
            />
          ))}
        </div>
        {isEditing && (
          <Editing
            cancelEdit={this.cancelEdit}
            editingTodo={editingTodo}
            handleEditingChange={this.handleEditingChange}
            handleUpdate={this.handleUpdate}
          />
        )}
        {isProcessing && <Processing />}
      </div>
    );
  }
}

export default App;
