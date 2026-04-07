import Streamers, {type LiveStreamer} from "@components/Streamers/Streamers.tsx";
import {useEffect, useState} from "react";
import api from "@/api/axiosConfig.ts";

export default function HomePage() {
    const [streamers, setStreamers] = useState<LiveStreamer[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        let cancelled = false;
        setLoading(true);
        setError(null);
        api
            .get<LiveStreamer[]>("/streamers/live")
            .then((res) => {
                if (!cancelled) {
                    setStreamers(res.data);
                }
            })
            .catch(() => {
                if (!cancelled) {
                    setError("Failed to load live streamers.");
                }
            })
            .finally(() => {
                if (!cancelled) {
                    setLoading(false);
                }
            });
        return () => {
            cancelled = true;
        };
    }, []);

    return (
        <div className="flex flex-col gap-8 p-4">
            <h1 className="text-2xl font-semibold">Stream app</h1>
            <Streamers streamers={streamers} loading={loading} error={error} />
        </div>
    );
}
