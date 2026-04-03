import {login} from "../../api/auth.ts";
import AuthForm from "../UI/Form/AuthForm.tsx";

export default function Login() {
    return <AuthForm fields={["email", "password"]} onSubmit={login} buttonLabel="Login" />;
}
