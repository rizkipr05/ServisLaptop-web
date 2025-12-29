import Echo from "laravel-echo";
import Pusher from "pusher-js";

export function createEcho(token) {
    window.Pusher = Pusher;

    return new Echo({
        broadcaster: "reverb",
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "http") === "https",
        enabledTransports: ["ws", "wss"],

        authEndpoint: `${import.meta.env.VITE_API_BASE_URL}/broadcasting/auth`,
        auth: {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        },
    });
}
