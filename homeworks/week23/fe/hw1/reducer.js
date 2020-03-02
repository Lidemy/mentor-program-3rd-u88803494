import {
  UPDATE_POSTS_LIST,
  CHANGE_POSTS,
  SHOW_ARTICLE_MANAGEMENT_WINDOW,
  HIDE_ARTICLE_MANAGEMENT_WINDOW,
} from './actionTypes';

const postsState = {
  postsListData: [],
};

const windowState = {
  method: '',
  show: false, // 是否顯現的值
  postId: null,
};

const postsReducer = (globalState = postsState, action) => {
  const handleChangePosts = ({ method, thisPost, postId }) => {
    /** 第一個變數是方式，第二個之後是變更的資料 */
    const { postsListData } = globalState;
    switch (method) {
      case 'create': {
        const id = postsListData.length !== 0 ? postsListData[0].id + 1 : 1;
        return {
          postsListData: [{
            ...thisPost,
            createdAt: new Date().getTime(), // 取得當前的 timestamp，有很大的機會跟伺服器上的不同
            id, // 取得資料已經逆排序，所以取 index 0 的就是最後 id
          },
          ...postsListData, // 放後面才能符合逆排序
          ],
        };
      }
      case 'editing':
        return {
          postsListData: postsListData.map((post) => {
            if (post.id !== thisPost.id) return post;
            return {
              ...post,
              ...thisPost,
            };
          }),
        };
      case 'delete':
        return {
          postsListData: postsListData.filter(post => post.id !== postId),
        };
      default:
        return null;
    }
  };

  switch (action.type) {
    case UPDATE_POSTS_LIST:
      return {
        postsListData: action.posts,
      };
    case CHANGE_POSTS:
      return handleChangePosts(action.post);
    default:
      return globalState;
  }
};

const wnidowReducer = (globalState = windowState, action) => {
  switch (action.type) {
    case SHOW_ARTICLE_MANAGEMENT_WINDOW:
      return {
        ...action.postState,
        show: true,
      };
    case HIDE_ARTICLE_MANAGEMENT_WINDOW:
      return {
        ...windowState, // 把狀態還原
      };
    default:
      return globalState;
  }
};

export { postsReducer, wnidowReducer };
