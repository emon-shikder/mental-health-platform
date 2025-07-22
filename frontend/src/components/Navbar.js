import React, { useState } from 'react';
import { Link, useNavigate, useLocation } from 'react-router-dom';
import { authService } from '../services/authService';
import { NAVIGATION_ITEMS } from '../utils/constants';

const Navbar = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const navigate = useNavigate();
  const location = useLocation();
  const isAuthenticated = authService.isAuthenticated();
  const currentUser = authService.getCurrentUser();

  const handleLogout = () => {
    authService.logout();
    navigate('/login');
  };

  const isActive = (path) => {
    return location.pathname === path;
  };

  return (
    <nav className="bg-white/95 backdrop-blur-md shadow-lg fixed top-0 w-full z-50 border-b border-gray-100">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          {/* Logo and brand */}
          <div className="flex items-center">
            <Link to="/" className="flex-shrink-0 flex items-center group">
              <div className="relative">
                <span className="text-3xl mr-3 group-hover:scale-110 transition-transform duration-200">🧠</span>
                <div className="absolute -top-1 -right-1 w-3 h-3 bg-primary-500 rounded-full animate-pulse"></div>
              </div>
              <div>
                <span className="text-xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">
                  Mental Health Support
                </span>
                <p className="text-xs text-gray-500 -mt-1">Student Platform</p>
              </div>
            </Link>
          </div>

          {/* Desktop navigation */}
          <div className="hidden md:flex items-center space-x-1">
            {NAVIGATION_ITEMS.filter(item => item.path !== '/profile').map((item) => (
              <Link
                key={item.path}
                to={item.path}
                className={`flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${
                  isActive(item.path)
                    ? 'text-primary-600 bg-primary-50 shadow-sm'
                    : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50 hover:shadow-sm'
                }`}
              >
                <span className="mr-2 text-lg">{item.icon}</span>
                {item.label}
              </Link>
            ))}
          </div>

          {/* Auth buttons */}
          <div className="hidden md:flex items-center space-x-3">
            {isAuthenticated ? (
              <div className="flex items-center space-x-3">
                <div className="text-right">
                  <p className="text-sm font-medium text-gray-900">
                    Welcome, {currentUser?.first_name || 'User'}
                  </p>
                  <p className="text-xs text-gray-500">Anonymous ID: #{currentUser?.id}</p>
                </div>
                <Link
                  to="/profile"
                  className="flex items-center space-x-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2 rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                  <span className="text-lg">👤</span>
                  <span className="font-medium">Profile</span>
                </Link>
                <button
                  onClick={handleLogout}
                  className="btn-outline text-sm hover:bg-red-50 hover:border-red-300 hover:text-red-600"
                >
                  Logout
                </button>
              </div>
            ) : (
              <div className="flex items-center space-x-3">
                <div className="relative group">
                  <button className="text-gray-700 hover:text-primary-600 font-medium transition-colors duration-200 flex items-center space-x-1">
                    <span>Login</span>
                    <span className="text-xs">▼</span>
                  </button>
                  <div className="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div className="py-2">
                      <Link
                        to="/login"
                        className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                      >
                        👨‍🎓 Student Login
                      </Link>
                      <Link
                        to="/counselor/login"
                        className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                      >
                        🧠 Professional Login
                      </Link>
                    </div>
                  </div>
                </div>
                <div className="relative group">
                  <button className="bg-gradient-to-r from-primary-500 to-secondary-500 hover:from-primary-600 hover:to-secondary-600 text-white font-medium py-2 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center space-x-1">
                    <span>Get Started</span>
                    <span className="text-xs">▼</span>
                  </button>
                  <div className="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div className="py-2">
                      <Link
                        to="/register"
                        className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                      >
                        👨‍🎓 Student Registration
                      </Link>
                      <Link
                        to="/counselor/register"
                        className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                      >
                        🧠 Professional Registration
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            )}
          </div>

          {/* Mobile menu button */}
          <div className="md:hidden flex items-center">
            <button
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              className="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-colors duration-200"
            >
              <span className="sr-only">Open main menu</span>
              {isMenuOpen ? (
                <svg className="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              ) : (
                <svg className="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              )}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu */}
      {isMenuOpen && (
        <div className="md:hidden">
          <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white/95 backdrop-blur-md border-t border-gray-100">
            {NAVIGATION_ITEMS.filter(item => item.path !== '/profile').map((item) => (
              <Link
                key={item.path}
                to={item.path}
                className={`flex items-center px-3 py-3 rounded-lg text-base font-medium transition-all duration-200 ${
                  isActive(item.path)
                    ? 'text-primary-600 bg-primary-50 shadow-sm'
                    : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50 hover:shadow-sm'
                }`}
                onClick={() => setIsMenuOpen(false)}
              >
                <span className="mr-3 text-xl">{item.icon}</span>
                {item.label}
              </Link>
            ))}
            
            {/* Mobile auth buttons */}
            <div className="pt-4 pb-3 border-t border-gray-200">
              {isAuthenticated ? (
                <div className="space-y-3">
                  <div className="px-3 py-2">
                    <p className="text-sm font-medium text-gray-900">
                      Welcome, {currentUser?.first_name || 'User'}
                    </p>
                    <p className="text-xs text-gray-500">Anonymous ID: #{currentUser?.id}</p>
                  </div>
                  <Link
                    to="/profile"
                    className="flex items-center px-3 py-3 text-base font-medium bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all duration-200"
                    onClick={() => setIsMenuOpen(false)}
                  >
                    <span className="mr-3 text-xl">👤</span>
                    Profile
                  </Link>
                  <button
                    onClick={() => {
                      handleLogout();
                      setIsMenuOpen(false);
                    }}
                    className="w-full text-left px-3 py-3 text-base font-medium text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                  >
                    Logout
                  </button>
                </div>
              ) : (
                <div className="space-y-3">
                  <div className="px-3 py-2">
                    <p className="text-sm font-medium text-gray-900 mb-2">Student Access</p>
                    <Link
                      to="/login"
                      className="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-all duration-200"
                      onClick={() => setIsMenuOpen(false)}
                    >
                      👨‍🎓 Student Login
                    </Link>
                    <Link
                      to="/register"
                      className="block px-3 py-2 text-sm font-medium bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg hover:from-primary-600 hover:to-secondary-600 transition-all duration-200 text-center"
                      onClick={() => setIsMenuOpen(false)}
                    >
                      👨‍🎓 Student Registration
                    </Link>
                  </div>
                  <div className="px-3 py-2 border-t border-gray-200">
                    <p className="text-sm font-medium text-gray-900 mb-2">Professional Access</p>
                    <Link
                      to="/counselor/login"
                      className="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-all duration-200"
                      onClick={() => setIsMenuOpen(false)}
                    >
                      🧠 Professional Login
                    </Link>
                    <Link
                      to="/counselor/register"
                      className="block px-3 py-2 text-sm font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 text-center"
                      onClick={() => setIsMenuOpen(false)}
                    >
                      🧠 Professional Registration
                    </Link>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      )}
    </nav>
  );
};

export default Navbar; 