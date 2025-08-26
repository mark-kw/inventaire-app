import api from "./api";
import { handleResponseError } from "./refresh";

export function attachInterceptors() {
    api.interceptors.response.use(
        (r) => r,
        (error) => handleResponseError(error)
    );
}