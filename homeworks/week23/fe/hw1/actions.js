import {
  UPDATE_POSTS_LIST,
  CHANGE_POSTS,
  SHOW_ARTICLE_MANAGEMENT_WINDOW,
  HIDE_ARTICLE_MANAGEMENT_WINDOW,
} from './actionTypes';

export const updatePosts = posts => ({
  type: UPDATE_POSTS_LIST,
  posts,
});

export const changePosts = post => ({
  type: CHANGE_POSTS,
  post,
});

export const showManagementWindow = postState => ({
  type: SHOW_ARTICLE_MANAGEMENT_WINDOW,
  postState,
});

export const hideMangementWindow = postState => ({
  type: HIDE_ARTICLE_MANAGEMENT_WINDOW,
  postState,
});
