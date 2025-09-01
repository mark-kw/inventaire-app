import { jwtDecode } from "jwt-decode";


type JWTPayload = { exp?: number; iat?: number }


export function isTokenValid(token?: string | null): boolean {
    if (!token) return false

    try {
        const { exp } = jwtDecode<JWTPayload>(token)
        if (!exp) return false
        const now = Date.now() / 1000;
        return now < exp - 15
    } catch (error) {
        return false
    }
}