export default function Errors({errors}: {errors: string[]}) {
    return (
        errors.length > 0 && (
            <div className={"my-3 p-2 bg-red-500 shadow-2xl rounded-md"}>
                {errors.map((e: string) => (
                    <span key={e} className={"block text-white"}>
                        {e}
                    </span>
                ))}
            </div>
        )
    );
}
