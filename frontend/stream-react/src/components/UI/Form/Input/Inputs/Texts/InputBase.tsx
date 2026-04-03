import type {InputProps} from "../../../../../../types/InputProps";

export default function InputBase({type, ...props}: InputProps) {
    return <input type={type} {...props} className="input input-bordered w-full" />;
}
