import {useAuthStore} from "@store/authStore.ts";

export const useIsAuth = () => useAuthStore((state) => !!state.accessToken);