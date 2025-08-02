import { useForm } from "react-hook-form";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import InputField from "../components/InputField";


const loginSchema = z.object({
    email: z.string().email({ message: "Email invalide" }),
    password: z.string().min(6, { message: "Minimum 6 caractères" })
});

type LoginFormData = z.infer<typeof loginSchema>

export default function Login() {
    const { register, handleSubmit, formState: { errors }, } = useForm<LoginFormData>({ resolver: zodResolver(loginSchema) });

    const onSubmit = (data: LoginFormData) => {
        console.log('Login data:', data);
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-50">
            <form
                onSubmit={handleSubmit(onSubmit)}
                className="bg-white p-6 rounded-lg shadow-md w-full max-w-sm"
            >
                <h2 className="text-2xl font-semibold mb-6 text-center">Connexion</h2>
                <InputField label="Email" name="email" type="email" register={register} error={errors.email?.message} />
                <InputField label="Mot de passe" name="password" type="password" register={register} error={errors.password?.message} />
                <button
                    type="submit"
                    className="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition"
                >
                    Se connecter
                </button>
            </form>
        </div>
    )

}


