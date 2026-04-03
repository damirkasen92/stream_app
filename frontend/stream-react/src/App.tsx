import MainLayout from "./layouts/MainLayout/MainLayout.tsx";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import HomePage from "./pages/HomePage/HomePage.tsx";
import LoginPage from "./pages/LoginPage/LoginPage.tsx";
import RegisterPage from "./pages/RegisterPage/RegisterPage.tsx";

export default function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<MainLayout />}>
                    <Route index element={<HomePage />} />
                    <Route path="/login" element={<LoginPage />} />
                    <Route path="/register" element={<RegisterPage />} />
                </Route>

                {/*// there's will be a stream component here in the future*/}
                {/*<Route element={<ProtectedRoute />}>*/}

                {/*</Route>*/}
            </Routes>
        </BrowserRouter>
    );
}
