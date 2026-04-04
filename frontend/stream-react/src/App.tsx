import MainLayout from "./layouts/MainLayout/MainLayout.tsx";
import {BrowserRouter, Navigate, Route, Routes} from "react-router-dom";
import HomePage from "./pages/HomePage/HomePage.tsx";
import LoginPage from "./pages/LoginPage/LoginPage.tsx";
import RegisterPage from "./pages/RegisterPage/RegisterPage.tsx";
import ProtectedRoute from "./routes/ProtectedRoute.tsx";
import {useIsAuth} from "./store/authStore.ts";
import CreateStreamPage from "./pages/CreateStreamPage/CreateStreamPage.tsx";

export default function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<MainLayout />}>
                    <Route index element={<HomePage />} />
                    <Route path="/login" element={useIsAuth() ? <Navigate to="/" replace /> : <LoginPage />} />
                    <Route path="/register" element={useIsAuth() ? <Navigate to="/" replace /> : <RegisterPage />} />

                    {/*// there's will be a stream component here in the future*/}
                    <Route element={<ProtectedRoute />}>
                        <Route path="/stream">
                            <Route path="/stream/create" element={<CreateStreamPage />} />

                            {/*  watch stream page here  */}
                        </Route>
                    </Route>
                </Route>
            </Routes>
        </BrowserRouter>
    );
}
