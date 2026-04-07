import api from "./axiosConfig.ts";
import {useAuthStore} from "../store/authStore";
import type {AxiosResponse} from "axios";

const setAuthToken = (res: AxiosResponse) => {
    useAuthStore.getState().setToken(res.data.access_token, res.data.expires_in);
}

export async function login(data: Record<string, string>) {
    const res = await api.post("/auth/login", data);
    setAuthToken(res);
}

export async function register(data: Record<string, string>) {
    const res = await api.post("/auth/register", data);
    setAuthToken(res);
}

export async function refresh() {
    const res = await api.post("/auth/refresh", {});
    setAuthToken(res);
}

export async function logout() {
    useAuthStore.getState().clearToken();
    await api.post("/auth/logout");
}
