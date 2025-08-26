import api, { setAccessToken, getRefreshToken } from "./api";

let isRefreshing = false;
let queue: Array<(token: string | null) => void> = [];

async function requestNewAccessToken() {
    const rt = getRefreshToken();
    if (!rt) return null;
    const { data } = await api.post("/api/token/refresh", { refresh_token: rt });
    const newTok = data?.token as string | undefined;
    if (!newTok) return null

    setAccessToken(newTok);
    return newTok;
}

export async function handleResponseError(error: any) {
    const original = error.config;

    if (error?.response?.status !== 401 || original?._retry) throw error;
    original._retry = true;

    if (isRefreshing) {
        return new Promise((resolve, reject) => {
            queue.push((newTok) => {
                if (newTok) {
                    original.headers.Authorization = `Bearer ${newTok}`;
                    resolve(api.request(original));
                } else {
                    reject(error);
                }
            });
        });
    }

    isRefreshing = true;
    try {
        const newTok = await requestNewAccessToken();
        queue.forEach((cb) => cb(newTok));
        queue = [];
        if (!newTok) throw error;

        original.headers.Authorization = `Bearer ${newTok}`;
        return api.request(original);
    } catch (e) {
        queue.forEach((cb) => cb(null));
        queue = [];
        throw e;
    } finally {
        isRefreshing = false;
    }
}