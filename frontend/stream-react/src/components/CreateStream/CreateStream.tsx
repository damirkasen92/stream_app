import * as React from "react";
import {useState} from "react";
import Errors from "@components/UI/Errors/Errors.tsx";
import Input from "@components/UI/Form/Input/Input.tsx";
import {createStream} from "@/api/stream.ts";

export default function CreateStream() {
    const [data, setData] = useState<Record<string, string>>({
        title: "",
        description: "",
    });
    const [errors, setErrors] = useState<string[]>([]);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setData({...data, [e.target.name]: e.target.value});
    };

    const handleSubmit = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        setErrors([]);

        createStream(data).catch((errs: Record<string, string[]>) => {
            const allErrors = Object.values(errs).flat();
            setErrors(allErrors);
        });
    };

    const fields = [
        "title",
        "description",
    ]

    return (
        <div className="mx-auto my-auto max-w-[335px] w-full">
            <form onSubmit={handleSubmit}>
                {errors.length > 0 && <Errors errors={errors} />}

                {fields.map((field) => (
                    <div className={"mb-3"} key={field}>
                        <label className="label mb-3" htmlFor="title">
                            Stream {field}
                        </label>
                        <Input id={field} type={"text"} name={field} onChange={handleChange} value={data[field]} />
                    </div>
                ))}

                <button className="btn btn-secondary w-full mt-3" type="submit">
                    Create stream
                </button>
            </form>
        </div>
    );
}
