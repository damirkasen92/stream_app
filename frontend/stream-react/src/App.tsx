import {BrowserRouter, Navigate, Route, Routes} from "react-router-dom";
import MainLayout from "@/layouts/MainLayout/MainLayout.tsx";
import HomePage from "@pages/HomePage/HomePage.tsx";
import LoginPage from "@pages/LoginPage/LoginPage.tsx";
import RegisterPage from "@pages/RegisterPage/RegisterPage.tsx";
import ProtectedRoute from "@/routes/ProtectedRoute.tsx";
import CreateStreamPage from "@/pages/CreateStreamPage/CreateStreamPage.tsx";
import StreamPreview from "@components/StreamPreview/StreamPreview.tsx";
import WatchStreamPage from "@pages/WatchStreamPage/WatchStreamPage.tsx";
import VodsPage from "@pages/VodsPage/VodsPage.tsx";
import WatchVodPage from "@pages/WatchVodPage/WatchVodPage.tsx";
import {useIsAuth} from "@/hooks/useIsAuth.ts";

export default function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<MainLayout />}>
                    <Route index element={<HomePage />} />
                    <Route path="/watch/:userId" element={<WatchStreamPage />} />
                    
                    <Route path="/vods" element={<VodsPage />} />
                    <Route path="/vod/:userId/:recordedAt" element={<WatchVodPage />} />

                    <Route path="/login" element={useIsAuth() ? <Navigate to="/" replace /> : <LoginPage />} />
                    <Route path="/register" element={useIsAuth() ? <Navigate to="/" replace /> : <RegisterPage />} />

                    <Route element={<ProtectedRoute />}>
                        <Route path="/stream">
                            <Route path="/stream/create" element={<CreateStreamPage />} />
                            <Route path="/stream/:id/preview" element={<StreamPreview />} />
                        </Route>
                    </Route>
                </Route>
            </Routes>
        </BrowserRouter>
    );
}
