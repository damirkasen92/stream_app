import Header from "@components/Header/Header.tsx";
import Footer from "@components/Footer/Footer.tsx";
import {Outlet, useLocation} from "react-router-dom";
import {motion} from "framer-motion";

export default function MainLayout() {
    const location = useLocation();

    return (
        <>
            <Header />
            <div className={"container mx-auto mt-3 px-3"}>
                <motion.main
                    key={location.pathname}
                    initial={{opacity: 0, y: 20}}
                    animate={{opacity: 1, y: 0}}
                    exit={{opacity: 0, y: -20}}
                    transition={{duration: 0.3}}
                    className={"flex flex-col h-full"}
                >
                    <Outlet />
                </motion.main>
            </div>
            <Footer />
        </>
    );
}
