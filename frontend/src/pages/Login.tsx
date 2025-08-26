import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useNavigate } from "react-router-dom";

export default function Login() {
    const { login } = useAuth();
    const nav = useNavigate();
    const [email, setEmail] = useState("admin@kafland.tg");
    const [password, setPassword] = useState("admin");
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const onSubmit = async (e: React.FormEvent) => {
        console.log("al")
        e.preventDefault();
        setLoading(true); setError(null);
        try {
            await login(email, password);
            nav("/", { replace: true });
        } catch (err: any) {
            setError(err?.response?.data?.message ?? "Échec de connexion");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="min-h-screen grid place-items-center p-6">
            <form onSubmit={onSubmit} className="w-full max-w-sm space-y-4 border rounded-2xl p-6 shadow">
                <h1 className="text-2xl font-semibold">Kafland — Connexion</h1>
                <input className="w-full border rounded p-2" value={email} onChange={e => setEmail(e.target.value)} placeholder="Email" />
                <input className="w-full border rounded p-2" type="password" value={password} onChange={e => setPassword(e.target.value)} placeholder="Mot de passe" />
                {error && <div className="text-red-600 text-sm">{error}</div>}
                <button disabled={loading} className="w-full rounded-2xl p-2 border">{loading ? "..." : "Se connecter"}</button>
            </form>
        </div>
    );
}
