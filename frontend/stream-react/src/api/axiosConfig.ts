import axios from "axios";
import {refresh} from "./auth";
import {useAuthStore} from "../store/authStore";

const api = axios.create({
    baseURL: "/api",
    withCredentials: true,
});

api.interceptors.request.use((config) => {
    const {accessToken} = useAuthStore.getState();
    if (accessToken) {
        config.headers.Authorization = `Bearer ${accessToken}`;
    }
    return config;
});

api.interceptors.response.use(
    (response) => response,
    async (error) => {
        if (error.response?.data?.errors) {
            return Promise.reject(error.response.data.errors);
        }

        if (error.response?.status === 401) {
            try {
                const newToken = await refresh();
                error.config.headers["Authorization"] = `Bearer ${newToken}`;
                return api(error.config);
            } catch (refreshError) {
                useAuthStore.getState().clearToken();
                return Promise.reject(refreshError);
            }
        }
        return Promise.reject(error);
    }
);

export default api;
