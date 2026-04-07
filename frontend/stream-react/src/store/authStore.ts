import {create} from "zustand";
import {createJSONStorage, persist} from "zustand/middleware";

interface AuthState {
    accessToken: string | null;
    expiresIn: number | null;
    setToken: (token: string, expiresIn: number) => void;
    clearToken: () => void;
    isLoggedOut: boolean;
}

export const useAuthStore = create<AuthState>()(
    persist(
        (set) => ({
            accessToken: null,
            expiresIn: null,
            setToken: (token, expiresIn) => set({accessToken: token, expiresIn, isLoggedOut: false}),
            clearToken: () => set({accessToken: null, expiresIn: null, isLoggedOut: true}),
            isLoggedOut: false,
        }),
        {
            name: "auth",
            storage: createJSONStorage(() => localStorage),
        }
    )
);
