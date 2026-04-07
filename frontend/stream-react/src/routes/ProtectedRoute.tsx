import {Navigate, Outlet} from "react-router-dom";
import {useIsAuth} from "@/hooks/useIsAuth.ts";

export default function ProtectedRoute() {
    if (!useIsAuth()) {
        return <Navigate to="/login" replace />;
    }

    return <Outlet />;
};
