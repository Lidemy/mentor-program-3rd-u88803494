import React from 'react';

class Editing extends React.Component {
  Update = (e) => {
    if (e.key === 'Enter') {
      const { handleUpdate, editingTodo } = this.props;
      handleUpdate(editingTodo.id);
    }
  }

  Change = (e) => {
    const { handleEditingChange } = this.props;
    handleEditingChange(e.target.value);
  }

  render() {
    const { editingTodo, cancelEdit } = this.props;
    return (
      <div id="light" className="editing__area">
        <h1>編輯頁面</h1>
        <hr />
        <h6>Notice：編輯完成按下 enter 即可送出資料</h6>
        <input
          className="form-control form-control-sm"
          id="edit"
          type="text"
          placeholder="編輯完成後按下 enter 即可"
          value={editingTodo.text}
          onChange={this.Change}
          onKeyPress={this.Update}
        />
        <input type="hidden" className="editing__id" name="editing__id" />
        <button
          type="button"
          className="editing__cancel btn btn-outline-secondary"
          onClick={cancelEdit}
        >
          取消編輯
        </button>
      </div>
    );
  }
}

function Processing() {
  return <div id="fade" className="editing__background" />;
}

export { Editing, Processing };
