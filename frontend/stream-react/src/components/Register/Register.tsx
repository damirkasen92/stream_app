import AuthForm from "../UI/Form/AuthForm.tsx";
import {register} from "../../api/auth.ts";

export default function Register() {
    return <AuthForm fields={["name", "email", "password"]} onSubmit={register} buttonLabel="Register" />;
}
