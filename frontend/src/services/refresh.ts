import api, { setAccessToken, getRefreshToken, setRefreshToken } from "./api";

let isRefreshing = false;
let queue: Array<(token: string | null) => void> = [];


function clearAndRedirectToLogin() {
    try {
        setAccessToken(null)
        setRefreshToken(null)
    } finally {
        window.location.replace("/login");
    }
}

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
    const original = error?.config;

    if (!error?.response) throw error;

    const status = error.response.status;

    if (status !== 401) throw error;

    if (original?.url?.includes("/api/token/refresh")) {
        clearAndRedirectToLogin();
        return Promise.reject(error);
    }

    // Empêche un retry infini
    if (original?._retry) {
        clearAndRedirectToLogin();
        return Promise.reject(error);
    }
    original._retry = true;

    if (isRefreshing) {
        return new Promise((resolve, reject) => {
            queue.push((newTok) => {
                if (newTok) {
                    original.headers = original.headers ?? {};
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

        if (!newTok) {
            clearAndRedirectToLogin();
            return Promise.reject(error);
        }

        // Rejoue la requête initiale avec le nouveau token
        original.headers = original.headers ?? {};
        original.headers.Authorization = `Bearer ${newTok}`;
        return api.request(original);
    } catch (e) {
        // Échec inattendu → échec pour tout le monde
        queue.forEach((cb) => cb(null));
        queue = [];
        clearAndRedirectToLogin();
        return Promise.reject(e);
    } finally {
        isRefreshing = false;
    }
}