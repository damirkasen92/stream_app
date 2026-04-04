import {Navigate, Outlet} from "react-router-dom";
import {useIsAuth} from "../store/authStore.ts";

export default function ProtectedRoute() {
    if (!useIsAuth()) {
        return <Navigate to="/login" replace />;
    }

    return <Outlet />;
};
