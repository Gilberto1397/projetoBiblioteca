import axios from "axios";

const axiosProvider = axios.create({
    baseURL: 'http://localhost:8000',
    headers: {
        'Accept': 'application/json',
        'Content': 'application/json'
    },
    withCredentials: true
})

axiosProvider.interceptors.request.use((config) => {
    const xsrfToken = getCookie('XSRF-TOKEN'); // Usando a função do exemplo anterior

    if (xsrfToken) {
        config.headers['X-XSRF-TOKEN'] = xsrfToken; // 👈 Laravel espera esse header
    }
    return config;
});

function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (const cookie of cookies) {
        const [cookieName, cookieValue] = cookie.split('=');
        if (cookieName === name) {
            return decodeURIComponent(cookieValue);
        }
    }
    return null;
}

export default axiosProvider;