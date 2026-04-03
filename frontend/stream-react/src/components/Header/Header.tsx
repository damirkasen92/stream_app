import Navbar from "../Navbar/Navbar.tsx";

export default function Header() {
    return (
        <header className={"navbar bg-base-100 shadow-sm flex justify-between p-3"}>
            <a href="/">
                <span>My stream app</span>
            </a>

            <Navbar />
        </header>
    );
}
