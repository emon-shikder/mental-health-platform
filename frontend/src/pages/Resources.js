import React, { useState, useEffect } from 'react';
import { resourceService } from '../services/resourceService';
import { RESOURCE_TYPES } from '../utils/constants';

const Resources = () => {
  const [resources, setResources] = useState([]);
  const [filteredResources, setFilteredResources] = useState([]);
  const [selectedType, setSelectedType] = useState('all');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchResources();
  }, []);

  useEffect(() => {
    if (selectedType === 'all') {
      setFilteredResources(resources);
    } else {
      setFilteredResources(resources.filter(resource => resource.type === selectedType));
    }
  }, [selectedType, resources]);

  const fetchResources = async () => {
    try {
      setLoading(true);
      const data = await resourceService.getResources();
      setResources(data);
      setFilteredResources(data);
    } catch (err) {
      setError('Failed to load resources');
    } finally {
      setLoading(false);
    }
  };

  const getTypeIcon = (type) => {
    switch (type) {
      case 'article':
        return '📄';
      case 'video':
        return '🎥';
      case 'podcast':
        return '🎧';
      case 'book':
        return '📚';
      case 'app':
        return '📱';
      default:
        return '📄';
    }
  };

  const getTypeColor = (type) => {
    switch (type) {
      case 'article':
        return 'bg-blue-100 text-blue-800';
      case 'video':
        return 'bg-red-100 text-red-800';
      case 'podcast':
        return 'bg-purple-100 text-purple-800';
      case 'book':
        return 'bg-green-100 text-green-800';
      case 'app':
        return 'bg-orange-100 text-orange-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  if (loading) {
    return (
      <div className="pt-20 px-4 sm:px-6 lg:px-8">
        <div className="max-w-6xl mx-auto">
          <div className="text-center py-12">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto"></div>
            <p className="mt-4 text-gray-600">Loading resources...</p>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="pt-20 px-4 sm:px-6 lg:px-8">
      <div className="max-w-6xl mx-auto">
        <h1 className="text-3xl font-bold text-gray-900 mb-8">Mental Health Resources</h1>

        {error && (
          <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-6">
            {error}
          </div>
        )}

        {/* Filter Section */}
        <div className="mb-8">
          <div className="flex flex-wrap gap-2">
            <button
              onClick={() => setSelectedType('all')}
              className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                selectedType === 'all'
                  ? 'bg-primary-600 text-white'
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
              }`}
            >
              All Resources
            </button>
            {RESOURCE_TYPES.map((type) => (
              <button
                key={type.value}
                onClick={() => setSelectedType(type.value)}
                className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                  selectedType === type.value
                    ? 'bg-primary-600 text-white'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }`}
              >
                {getTypeIcon(type.value)} {type.label}
              </button>
            ))}
          </div>
        </div>

        {/* Resources Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredResources.map((resource) => (
            <div key={resource.id} className="card hover:shadow-lg transition-shadow">
              <div className="flex items-start justify-between mb-3">
                <span className="text-2xl">{getTypeIcon(resource.type)}</span>
                <span className={`px-2 py-1 rounded-full text-xs font-medium ${getTypeColor(resource.type)}`}>
                  {RESOURCE_TYPES.find(type => type.value === resource.type)?.label || resource.type}
                </span>
              </div>
              
              <h3 className="text-lg font-semibold text-gray-900 mb-2">
                {resource.title}
              </h3>
              
              <p className="text-gray-600 text-sm mb-4 line-clamp-3">
                {resource.description}
              </p>
              
              <div className="flex justify-between items-center">
                <span className="text-xs text-gray-500">
                  {resource.duration && `${resource.duration} min`}
                </span>
                <a
                  href={resource.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="btn-primary text-sm"
                >
                  View Resource
                </a>
              </div>
            </div>
          ))}
        </div>

        {filteredResources.length === 0 && (
          <div className="text-center py-12">
            <div className="text-6xl mb-4">📚</div>
            <h3 className="text-xl font-semibold text-gray-900 mb-2">
              {selectedType === 'all' ? 'No resources available' : `No ${selectedType} resources`}
            </h3>
            <p className="text-gray-600">
              {selectedType === 'all' 
                ? 'Check back later for new mental health resources.'
                : `No ${selectedType} resources available at the moment.`
              }
            </p>
          </div>
        )}

        {/* Resource Categories Info */}
        <div className="mt-12 bg-gray-50 rounded-lg p-6">
          <h2 className="text-xl font-semibold text-gray-900 mb-4">Resource Categories</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div className="flex items-center space-x-3">
              <span className="text-2xl">📄</span>
              <div>
                <h3 className="font-medium text-gray-900">Articles</h3>
                <p className="text-sm text-gray-600">In-depth articles and guides</p>
              </div>
            </div>
            <div className="flex items-center space-x-3">
              <span className="text-2xl">🎥</span>
              <div>
                <h3 className="font-medium text-gray-900">Videos</h3>
                <p className="text-sm text-gray-600">Educational videos and tutorials</p>
              </div>
            </div>
            <div className="flex items-center space-x-3">
              <span className="text-2xl">🎧</span>
              <div>
                <h3 className="font-medium text-gray-900">Podcasts</h3>
                <p className="text-sm text-gray-600">Audio content and discussions</p>
              </div>
            </div>
            <div className="flex items-center space-x-3">
              <span className="text-2xl">📚</span>
              <div>
                <h3 className="font-medium text-gray-900">Books</h3>
                <p className="text-sm text-gray-600">Recommended reading materials</p>
              </div>
            </div>
            <div className="flex items-center space-x-3">
              <span className="text-2xl">📱</span>
              <div>
                <h3 className="font-medium text-gray-900">Apps</h3>
                <p className="text-sm text-gray-600">Mobile applications and tools</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Resources; 