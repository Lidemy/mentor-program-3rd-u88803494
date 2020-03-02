import React from 'react';
import { connect } from 'react-redux';
import Posts from '../component/post_list';
import { updatePosts, showManagementWindow } from '../actions';

const PostsContainer = props => <Posts {...props} />;

const mapStateToProps = state => ({ // return 時，告訴需要什麼資料
  postsListData: state.posts.postsListData,
});
const mapDispatchToProps = dispatch => ({
  updatePosts: data => dispatch(updatePosts(data)),
  showManagementWindow: showData => dispatch(showManagementWindow(showData)),
});

export default connect(mapStateToProps, mapDispatchToProps)(PostsContainer);
