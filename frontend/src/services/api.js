import axios from 'axios';

/**
 * Cliente HTTP para consumir la API del backend.
 *
 * Nota:
 * - `baseURL: '/api'` funciona con el proxy de Vite hacia Laravel.
 * - La autenticación se maneja con token en el header Authorization.
 */
const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers = config.headers ?? {};
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Interceptor para manejar errores
api.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.hash = '#/login';
        }
        return Promise.reject(error);
    }
);

export default api;
