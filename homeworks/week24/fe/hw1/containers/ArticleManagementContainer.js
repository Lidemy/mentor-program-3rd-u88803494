import React from 'react';
import { connect } from 'react-redux';
import ArticleManagement from '../component/article_management';
import * as actions from '../actions';

const ArticleManagementContainer = props => <ArticleManagement {...props} />;

const mapStateToProps = state => ({
  ...state.postState,
  posts: state.posts.postsListData,
  shouldGetPosts: state.posts.shouldGetPosts,
  error: state.posts.error,
});

const mapDispatchToProps = dispatch => ({
  createPost: post => dispatch(actions.createPost(post)),
  updatePost: post => dispatch(actions.updatePost(post)),
  deletePost: id => dispatch(actions.deletePost(id)),
  errorCreatePost: post => dispatch(actions.errorCreatePost(post)),
  errorUpdatePost: post => dispatch(actions.errorUpdatePost(post)),
  errorDeletePost: id => dispatch(actions.errorDeletePost(id)),
  showManagementWindow: showData => dispatch(actions.showManagementWindow(showData)),
  onHide: () => dispatch(actions.hideMangementWindow()),
});

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(ArticleManagementContainer);
