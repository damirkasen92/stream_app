import {useState} from "react";
import Input from "./Input/Input.tsx";
import Errors from "../Errors/Errors.tsx";
import * as React from "react";

type AuthFormProps = {
    fields: string[];
    onSubmit: (data: Record<string, string>) => Promise<void>;
    buttonLabel: string;
};

export default function AuthForm({fields, onSubmit, buttonLabel}: AuthFormProps) {
    const [data, setData] = useState<Record<string, string>>(Object.fromEntries(fields.map((f) => [f, ""])));
    const [errors, setErrors] = useState<string[]>([]);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setData({...data, [e.target.name]: e.target.value});
    };

    const handleSubmit = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        setErrors([]);

        onSubmit(data).then(() => {

        }).catch((errs: Record<string, string[]>) => {
            const allErrors = Object.values(errs).flat();
            setErrors(allErrors);
        });
    };

    return (
        <div className="mx-auto my-auto max-w-[335px] w-full">
            <form onSubmit={handleSubmit}>
                {errors.length > 0 && <Errors errors={errors} />}

                {fields.map((field) => (
                    <div className="mb-3" key={field}>
                        <label className="label mb-3" htmlFor={field}>
                            <span className="capitalize">{field}</span>
                        </label>
                        <Input
                            id={field}
                            type={field}
                            name={field}
                            onChange={handleChange}
                            value={data[field]}
                        />
                    </div>
                ))}

                <button className="btn btn-secondary w-full mt-3" type="submit">
                    {buttonLabel}
                </button>
            </form>
        </div>
    );
}
