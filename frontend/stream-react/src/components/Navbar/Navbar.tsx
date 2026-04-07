import {Link} from "react-router-dom";
import {logout} from "@/api/auth.ts";
import {useIsAuth} from "@/hooks/useIsAuth.ts";

export default function Navbar() {
    return (
        <nav>
            <ul className={"flex gap-3"}>
                <li>
                    <Link to={"/"}>Streams</Link>
                </li>

                <li>
                    <Link to={"/vods"}>VODs</Link>
                </li>

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
                        </li>
                    </>
                )}
            </ul>
        </nav>
    );
}
