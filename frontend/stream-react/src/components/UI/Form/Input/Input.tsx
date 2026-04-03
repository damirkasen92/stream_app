import type {InputProps} from "../../../../types/InputProps.ts";
import InputBase from "./Inputs/Texts/InputBase.tsx";
import * as React from "react";

const inputs: {
    [key: string]: React.ComponentType<InputProps>;
} = {
    radio: InputBase,
    select: InputBase,
};

export default function Input({type, ...props}: InputProps) {
    const Component = inputs[type] || InputBase;

    if (!Component) {
        throw new Error("Input type is required");
    }

    return <Component type={type} {...props} />;
}
