import {create} from "zustand";

interface AuthState {
    accessToken: string | null;
    expiresIn: number | null;
    setToken: (token: string, expiresIn: number) => void;
    clearToken: () => void;
}

export const useAuthStore = create<AuthState>((set) => ({
    accessToken: null,
    expiresIn: null,
    setToken: (token, expiresIn) => set({accessToken: token, expiresIn}),
    clearToken: () => set({accessToken: null, expiresIn: null}),
}));
