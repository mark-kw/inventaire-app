import React from "react";

type InputFieldProps = {
    label: string;
    name: string;
    type?: string;
    register: any;
    error?: string;
}

const InputField: React.FC<InputFieldProps> = ({ label, name, type = "text", register, error }) => {
    return (
        <div className="mb-4">
            <label htmlFor={name} className="block text-sm font-medium text-gray-700 mb-1">
                {label}
            </label>
            <input
                type={type}
                id={name}
                {...register(name)}
                className={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 ${error ? "border-red-500" : "border-gray-300"
                    }`}
            />
            {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
        </div>
    )
}

export default InputField