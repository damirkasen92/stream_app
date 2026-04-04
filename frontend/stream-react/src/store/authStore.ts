import {create} from "zustand";
import {createJSONStorage, persist} from "zustand/middleware";

interface AuthState {
    accessToken: string | null;
    expiresIn: number | null;
    setToken: (token: string, expiresIn: number) => void;
    clearToken: () => void;
}

export const useAuthStore = create<AuthState>()(
    persist(
        (set) => ({
            accessToken: null,
            expiresIn: null,
            setToken: (token, expiresIn) => set({accessToken: token, expiresIn}),
            clearToken: () => set({accessToken: null, expiresIn: null}),
        }),
        {
            name: "auth",
            storage: createJSONStorage(() => localStorage),
        }
    )
);

// export const isAuth: boolean = !!useAuthStore.getState().accessToken;
export const useIsAuth = () => useAuthStore((state) => !!state.accessToken);
