import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { authService } from '../services/authService';

const Profile = () => {
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [deleting, setDeleting] = useState(false);
  const navigate = useNavigate();
  const currentUser = authService.getCurrentUser();

  const handleLogout = () => {
    authService.logout();
    navigate('/login');
  };

  const handleDeleteAccount = async () => {
    try {
      setDeleting(true);
      // This would typically call an API endpoint to delete the account
      // For now, we'll just log out the user
      authService.logout();
      navigate('/');
    } catch (error) {
      console.error('Failed to delete account:', error);
    } finally {
      setDeleting(false);
      setShowDeleteModal(false);
    }
  };

  if (!currentUser) {
    return (
      <div className="pt-20 px-4 sm:px-6 lg:px-8">
        <div className="max-w-4xl mx-auto">
          <div className="text-center py-12">
            <p className="text-gray-600">Please log in to view your profile.</p>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="pt-20 px-4 sm:px-6 lg:px-8">
      <div className="max-w-4xl mx-auto">
        <h1 className="text-3xl font-bold text-gray-900 mb-8">Profile</h1>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Profile Information */}
          <div className="lg:col-span-2">
            <div className="card">
              <h2 className="text-xl font-semibold text-gray-900 mb-6">Personal Information</h2>
              
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Anonymous User ID
                  </label>
                  <p className="text-lg font-mono bg-gray-100 px-3 py-2 rounded">
                    #{currentUser.id}
                  </p>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    First Name
                  </label>
                  <p className="text-lg text-gray-900">
                    {currentUser.first_name || 'Not provided'}
                  </p>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Last Name
                  </label>
                  <p className="text-lg text-gray-900">
                    {currentUser.last_name || 'Not provided'}
                  </p>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Email
                  </label>
                  <p className="text-lg text-gray-900">
                    {currentUser.email}
                  </p>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Member Since
                  </label>
                  <p className="text-lg text-gray-900">
                    {new Date(currentUser.date_joined).toLocaleDateString()}
                  </p>
                </div>
              </div>
            </div>

            {/* Privacy & Security */}
            <div className="card mt-6">
              <h2 className="text-xl font-semibold text-gray-900 mb-6">Privacy & Security</h2>
              
              <div className="space-y-4">
                <div className="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                  <div>
                    <h3 className="font-medium text-green-900">Anonymous Mode</h3>
                    <p className="text-sm text-green-700">
                      Your identity is protected in all interactions
                    </p>
                  </div>
                  <span className="text-green-600">✓ Active</span>
                </div>

                <div className="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                  <div>
                    <h3 className="font-medium text-blue-900">Secure Connection</h3>
                    <p className="text-sm text-blue-700">
                      All data is encrypted and securely transmitted
                    </p>
                  </div>
                  <span className="text-blue-600">✓ Active</span>
                </div>
              </div>
            </div>
          </div>

          {/* Account Actions */}
          <div className="space-y-6">
            <div className="card">
              <h2 className="text-xl font-semibold text-gray-900 mb-6">Account Actions</h2>
              
              <div className="space-y-4">
                <button
                  onClick={() => {/* TODO: Implement edit profile */}}
                  className="w-full btn-outline"
                >
                  Edit Profile
                </button>
                
                <button
                  onClick={() => {/* TODO: Implement change password */}}
                  className="w-full btn-outline"
                >
                  Change Password
                </button>
                
                <button
                  onClick={handleLogout}
                  className="w-full btn-secondary"
                >
                  Logout
                </button>
              </div>
            </div>

            <div className="card border-red-200">
              <h2 className="text-xl font-semibold text-red-900 mb-6">Danger Zone</h2>
              
              <div className="space-y-4">
                <div className="p-4 bg-red-50 rounded-lg">
                  <h3 className="font-medium text-red-900 mb-2">Delete Account</h3>
                  <p className="text-sm text-red-700 mb-4">
                    This action cannot be undone. All your data will be permanently deleted.
                  </p>
                  <button
                    onClick={() => setShowDeleteModal(true)}
                    className="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                  >
                    Delete Account
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Support Information */}
        <div className="mt-8 card bg-primary-50 border-primary-200">
          <h2 className="text-xl font-semibold text-primary-900 mb-4">Need Help?</h2>
          <p className="text-primary-700 mb-4">
            If you're experiencing any issues or have questions about your account, 
            our support team is here to help.
          </p>
          <div className="flex space-x-4">
            <button className="btn-primary">
              Contact Support
            </button>
            <button className="btn-outline border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white">
              View FAQ
            </button>
          </div>
        </div>
      </div>

      {/* Delete Account Modal */}
      {showDeleteModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-lg max-w-md w-full p-6">
            <h2 className="text-xl font-semibold text-red-900 mb-4">Delete Account</h2>
            <p className="text-gray-600 mb-6">
              Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.
            </p>
            <div className="flex space-x-3">
              <button
                onClick={() => setShowDeleteModal(false)}
                className="flex-1 btn-outline"
              >
                Cancel
              </button>
              <button
                onClick={handleDeleteAccount}
                disabled={deleting}
                className="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:opacity-50"
              >
                {deleting ? 'Deleting...' : 'Delete Account'}
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Profile; 