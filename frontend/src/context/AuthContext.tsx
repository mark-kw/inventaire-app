import { createContext, useContext, useEffect, useState } from "react";
import api, { setAccessToken, setRefreshToken } from "../services/api";

type User = { email: string; roles: string[] } | null;
type AuthCtx = {
    user: User,
    token: string | null,
    login: (email: string, password: string) => Promise<void>,
    logout: () => void
}

const Ctx = createContext<AuthCtx>({} as any);
export const useAuth = () => useContext(Ctx);

export function AuthProvider({ children }: { children: React.ReactNode }) {
    const [token, setToken] = useState<string | null>(localStorage.getItem("access_token"));
    const [user, setUser] = useState<User>(null);

    useEffect(() => {
        setAccessToken(token);
        // Optionnel: si tu exposes /api/me, récupère le profil ici
        // if (token) api.get('/api/me').then(({data}) => setUser(data)).catch(()=>setUser(null));
    }, [token]);

    const login = async (email: string, password: string) => {
        const { data } = await api.post("/api/login", { email, password });
        const access = data?.token as string | undefined;
        const refresh = data?.refresh_token as string | undefined;
        if (!access) throw new Error("Token manquant");
        setToken(access);
        setAccessToken(access);
        if (refresh) setRefreshToken(refresh);
        setUser({ email, roles: [] });
    };

    const logout = () => {
        setUser(null);
        setToken(null);
        setAccessToken(null);
        setRefreshToken(null);
    };


    return <Ctx.Provider value={{ user, token, login, logout }}>{children}</Ctx.Provider>;
}