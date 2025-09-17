import axios from 'axios';

// ----- Base URLs (from env, with sensible defaults) -----
const API_BASE =
  import.meta.env.VITE_API_BASE || 'http://localhost:4000/api';
console.log("VITE_API_BASE =", import.meta.env.VITE_API_BASE);
// derive origin for non-/api endpoints like /health
const ORIGIN = API_BASE.replace(/\/api\/?$/, '');

// Create axios instance
const api = axios.create({
  baseURL: API_BASE,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
  // If you later switch to cookie-based auth, uncomment below:
  // withCredentials: true,
});

// Request interceptor to add auth token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Response interceptor to handle errors
api.interceptors.response.use(
  (response) => response.data,
  (error) => {
    if (error.response?.status === 401) {
      // Unauthorized - clear token and redirect to login
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }

    return Promise.reject({
      message: error.response?.data?.message || error.message || 'เกิดข้อผิดพลาด',
      status: error.response?.status,
      data: error.response?.data,
    });
  }
);

// Auth API
export const authAPI = {
  login: (credentials) => api.post('/auth/login', credentials),
  register: (userData) => api.post('/auth/register', userData),
  registerAgent: (agentData) => api.post('/auth/register-agent', agentData),
  getMe: () => api.get('/auth/me'),
  logout: () => api.post('/auth/logout'),
  changePassword: (passwordData) => api.put('/auth/change-password', passwordData),
  refreshToken: (refreshToken) => api.post('/auth/refresh', { refreshToken }),
};

// Agents API
export const agentsAPI = {
  getAll: (params) => api.get('/agents', { params }),
  getById: (id) => api.get(`/agents/${id}`),
  create: (agentData) => api.post('/agents', agentData),
  update: (id, agentData) => api.put(`/agents/${id}`, agentData),
  delete: (id) => api.delete(`/agents/${id}`),
  getList: () => api.get('/agents/list'),
};

// Customers API
export const customersAPI = {
  getAll: (params) => api.get('/customers', { params }),
  getById: (id) => api.get(`/customers/${id}`),
  create: (customerData) => api.post('/customers', customerData),
  update: (id, customerData) => api.put(`/customers/${id}`, customerData),
  delete: (id) => api.delete(`/customers/${id}`),
  approve: (id) => api.put(`/customers/${id}/approve`),
};

// Projects API
export const projectsAPI = {
  getAll: (params) => api.get('/projects', { params }),
  getById: (id) => api.get(`/projects/${id}`),
  create: (projectData) => api.post('/projects', projectData),
  update: (id, projectData) => api.put(`/projects/${id}`, projectData),
  delete: (id) => api.delete(`/projects/${id}`),
};

// Health check
export const healthAPI = {
  check: () => axios.get(`${ORIGIN}/health`),
  testDB: () => axios.get(`${API_BASE}/test-db`),
};

export default api;