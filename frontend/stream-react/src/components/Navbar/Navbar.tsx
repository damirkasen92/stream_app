import {Link} from "react-router-dom";
import {useIsAuth} from "../../store/authStore.ts";
import {logout} from "../../api/auth.ts";

export default function Navbar() {
    return (
        <nav>
            <ul className={"flex gap-3"}>
                {!useIsAuth() && (
                    <>
                        <li>
                            <Link to={"/login"}>Sign In</Link>
                        </li>

                        <li>
                            <Link to={"/register"}>Sign Up</Link>
                        </li>
                    </>
                )}

                {useIsAuth() && (
                    <>
                        <li>
                            <Link to={"/stream/create"}>Create Stream</Link>
                        </li>

                        <li>
                            <span className={"cursor-pointer"} onClick={logout}>
                                Logout
                            </span>
                            {/*<Link onClick={logout}>Logout</Link>*/}
                        </li>
                    </>
                )}
            </ul>
        </nav>
    );
}
