import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from "@tailwindcss/vite";
import path from "path";

// https://vite.dev/config/
export default defineConfig({
    plugins: [tailwindcss(), react()],
    server: {
        proxy: {
            "/api": "http://localhost:8000",
        },
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "src"),
            "@components": path.resolve(__dirname, "src/components"),
            "@pages": path.resolve(__dirname, "src/pages"),
            "@store": path.resolve(__dirname, "src/store"),
            "@utils": path.resolve(__dirname, "src/utils"),
        },
    },
});
