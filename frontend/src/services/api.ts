import axios from "axios";

export const api = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    headers: {
        Accept: "application/ld+json",
        "Content-Type": "application/json",
    },
});

// Mémoire + localStorage (MVP)
let accessToken: string | null = localStorage.getItem("access_token");

export const setAccessToken = (token: string | null) => {
    accessToken = token;
    if (token) localStorage.setItem("access_token", token);
    else localStorage.removeItem("access_token");
};

export const getRefreshToken = () => localStorage.getItem("refresh_token");
export const setRefreshToken = (t: string | null) => {
    if (t) localStorage.setItem("refresh_token", t);
    else localStorage.removeItem("refresh_token");
};

// Attache le Bearer si présent
api.interceptors.request.use((config) => {
    if (accessToken) config.headers.Authorization = `Bearer ${accessToken}`;
    return config;
});

export default api;
