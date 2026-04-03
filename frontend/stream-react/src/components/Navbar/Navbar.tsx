import {Link} from "react-router-dom";

export default function Navbar() {
    return (
        <nav>
            <ul className={"flex gap-3"}>
                <li>
                    <Link to={"/login"}>Sign In</Link>
                </li>

                <li>
                    <Link to={"/register"}>Sign Up</Link>
                </li>
            </ul>
        </nav>
    );
}
