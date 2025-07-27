import React, { useState, useEffect } from 'react';
import { forumService } from '../services/forumService';
import { formatRelativeTime } from '../utils/dateUtils';

const Forum = () => {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [showCreateModal, setShowCreateModal] = useState(false);
  const [newPost, setNewPost] = useState({ title: '', content: '' });
  const [submitting, setSubmitting] = useState(false);
  const [expandedComments, setExpandedComments] = useState({});
  const [commentText, setCommentText] = useState({});

  useEffect(() => {
    fetchPosts();
  }, []);

  const fetchPosts = async () => {
    try {
      setLoading(true);
      const data = await forumService.getPosts();
      setPosts(data);
    } catch (err) {
      setError('Failed to load posts');
    } finally {
      setLoading(false);
    }
  };

  const handleCreatePost = async (e) => {
    e.preventDefault();
    if (!newPost.title.trim() || !newPost.content.trim()) return;

    try {
      setSubmitting(true);
      const createdPost = await forumService.createPost(newPost.title, newPost.content);
      setPosts([createdPost, ...posts]);
      setNewPost({ title: '', content: '' });
      setShowCreateModal(false);
    } catch (err) {
      setError('Failed to create post');
    } finally {
      setSubmitting(false);
    }
  };

  const handleLike = async (postId) => {
    try {
      await forumService.likePost(postId);
      setPosts(posts.map(post => 
        post.id === postId 
          ? { ...post, likes: (post.likes || 0) + 1, is_liked: true }
          : post
      ));
    } catch (err) {
      setError('Failed to like post');
    }
  };

  const toggleComments = async (postId) => {
    if (!expandedComments[postId]) {
      try {
        const comments = await forumService.getComments(postId);
        setPosts(posts.map(post => 
          post.id === postId ? { ...post, comments } : post
        ));
      } catch (err) {
        setError('Failed to load comments');
      }
    }
    setExpandedComments(prev => ({
      ...prev,
      [postId]: !prev[postId]
    }));
  };

  const handleAddComment = async (postId) => {
    const content = commentText[postId];
    if (!content?.trim()) return;

    try {
      const newComment = await forumService.addComment(postId, content);
      setPosts(posts.map(post => 
        post.id === postId 
          ? { ...post, comments: [...(post.comments || []), newComment] }
          : post
      ));
      setCommentText(prev => ({ ...prev, [postId]: '' }));
    } catch (err) {
      setError('Failed to add comment');
    }
  };

  if (loading) {
    return (
      <div className="pt-20 px-4 sm:px-6 lg:px-8">
        <div className="max-w-4xl mx-auto">
          <div className="text-center py-12">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto"></div>
            <p className="mt-4 text-gray-600">Loading posts...</p>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="pt-20 px-4 sm:px-6 lg:px-8">
      <div className="max-w-4xl mx-auto">
        {/* Header */}
        <div className="flex justify-between items-center mb-8">
          <h1 className="text-3xl font-bold text-gray-900">Community Forum</h1>
          <button
            onClick={() => setShowCreateModal(true)}
            className="btn-primary"
          >
            Create Post
          </button>
        </div>

        {error && (
          <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-6">
            {error}
          </div>
        )}

        {/* Posts */}
        <div className="space-y-6">
          {posts.map((post) => (
            <div key={post.id} className="card">
              <div className="flex justify-between items-start mb-4">
                <div>
                  <h3 className="text-xl font-semibold text-gray-900 mb-2">
                    {post.title}
                  </h3>
                  <p className="text-gray-600 mb-4">{post.content}</p>
                </div>
              </div>

              <div className="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div className="flex items-center space-x-4">
                  <span>Anonymous User #{post.user_id}</span>
                  <span>{formatRelativeTime(post.created_at)}</span>
                </div>
                <div className="flex items-center space-x-4">
                  <button
                    onClick={() => handleLike(post.id)}
                    className={`flex items-center space-x-1 ${
                      post.is_liked ? 'text-primary-600' : 'text-gray-500 hover:text-primary-600'
                    }`}
                  >
                    <span>👍</span>
                    <span>{post.likes || 0}</span>
                  </button>
                  <button
                    onClick={() => toggleComments(post.id)}
                    className="flex items-center space-x-1 text-gray-500 hover:text-primary-600"
                  >
                    <span>💬</span>
                    <span>{post.comments?.length || 0}</span>
                  </button>
                </div>
              </div>

              {/* Comments Section */}
              {expandedComments[post.id] && (
                <div className="border-t pt-4">
                  <h4 className="font-medium text-gray-900 mb-3">Comments</h4>
                  
                  {/* Comments List */}
                  <div className="space-y-3 mb-4">
                    {post.comments?.map((comment) => (
                      <div key={comment.id} className="bg-gray-50 p-3 rounded-lg">
                        <div className="flex justify-between items-start">
                          <p className="text-gray-800">{comment.content}</p>
                        </div>
                        <div className="flex items-center space-x-2 mt-2 text-xs text-gray-500">
                          <span>Anonymous User #{comment.user_id}</span>
                          <span>{formatRelativeTime(comment.created_at)}</span>
                        </div>
                      </div>
                    ))}
                  </div>

                  {/* Add Comment */}
                  <div className="flex space-x-2">
                    <input
                      type="text"
                      placeholder="Add a comment..."
                      value={commentText[post.id] || ''}
                      onChange={(e) => setCommentText(prev => ({
                        ...prev,
                        [post.id]: e.target.value
                      }))}
                      className="flex-1 input-field"
                      onKeyPress={(e) => e.key === 'Enter' && handleAddComment(post.id)}
                    />
                    <button
                      onClick={() => handleAddComment(post.id)}
                      className="btn-primary"
                    >
                      Comment
                    </button>
                  </div>
                </div>
              )}
            </div>
          ))}
        </div>

        {posts.length === 0 && !loading && (
          <div className="text-center py-12">
            <p className="text-gray-600">No posts yet. Be the first to share!</p>
          </div>
        )}
      </div>

      {/* Create Post Modal */}
      {showCreateModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-lg max-w-md w-full p-6">
            <h2 className="text-xl font-semibold mb-4">Create New Post</h2>
            <form onSubmit={handleCreatePost}>
              <div className="mb-4">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Title
                </label>
                <input
                  type="text"
                  value={newPost.title}
                  onChange={(e) => setNewPost(prev => ({ ...prev, title: e.target.value }))}
                  className="input-field"
                  placeholder="Enter post title"
                  required
                />
              </div>
              <div className="mb-4">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Content
                </label>
                <textarea
                  value={newPost.content}
                  onChange={(e) => setNewPost(prev => ({ ...prev, content: e.target.value }))}
                  className="input-field"
                  rows="4"
                  placeholder="Share your thoughts..."
                  required
                />
              </div>
              <div className="flex space-x-3">
                <button
                  type="button"
                  onClick={() => setShowCreateModal(false)}
                  className="flex-1 btn-outline"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  disabled={submitting}
                  className="flex-1 btn-primary"
                >
                  {submitting ? 'Creating...' : 'Create Post'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default Forum; 