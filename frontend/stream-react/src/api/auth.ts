import api from "./axiosConfig.ts";
import {useAuthStore} from "../store/authStore";

export async function login(data: {email: string, password: string}) {
    const res = await api.post("/auth/login", data);
    useAuthStore.getState().setToken(res.data.access_token, res.data.expires_in);
}

export async function register(data: {name: string, email: string; password: string}) {
    const res = await api.post("/auth/register", data);
    useAuthStore.getState().setToken(res.data.access_token, res.data.expires_in);
}

export async function refresh() {
    const res = await api.post("/auth/refresh", {});
    useAuthStore.getState().setToken(res.data.access_token, res.data.expires_in);
}

export async function logout() {
    await api.post("/auth/logout");
    useAuthStore.getState().clearToken();
}
