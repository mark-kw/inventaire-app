import { useEffect, useState } from "react";
import api from "../services/api";

type Room = { id: string; number?: string; name?: string; status?: string };

export default function Rooms() {
    const [rooms, setRooms] = useState<Room[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        (async () => {
            try {
                const { data } = await api.get("/api/rooms?pagination=false");
                setRooms(data["hydra:member"] ?? data);
            } finally { setLoading(false); }
        })();
    }, []);

    if (loading) return <div className="p-4">Chargement…</div>;
    return (
        <div className="p-6">
            <h1 className="text-2xl mb-4">Chambres</h1>
            <ul className="space-y-2">
                {rooms.map((r) => (
                    <li key={r.id} className="border rounded p-3">
                        <div className="font-medium">{r.number ?? r.name}</div>
                        <div className="text-sm opacity-70">{r.status}</div>
                    </li>
                ))}
            </ul>
        </div>
    );
}
