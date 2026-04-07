import {useEffect, useState} from "react";
import {Link} from "react-router-dom";
import api from "@/api/axiosConfig.ts";

type VodListItem = {
    user_id: number;
    stream_id: number;
    title: string;
    recorded_at: string;
};

export default function VodsPage() {
    const [vods, setVods] = useState<VodListItem[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        let cancelled = false;
        setLoading(true);
        setError(null);
        api
            .get<VodListItem[]>("/vods")
            .then((res) => {
                if (!cancelled) {
                    setVods(res.data);
                }
            })
            .catch(() => {
                if (!cancelled) {
                    setError("Failed to load VODs.");
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

    if (loading) {
        return <p className="p-4 text-neutral-400">Loading VODs...</p>;
    }

    if (error) {
        return <p className="p-4 text-red-400">{error}</p>;
    }

    return (
        <div className="mx-auto flex w-full max-w-5xl flex-col gap-4 p-4">
            <h1 className="text-2xl font-semibold">VODs</h1>

            {vods.length === 0 ? (
                <p className="text-neutral-400">No VODs yet.</p>
            ) : (
                <ul className="flex flex-col gap-3">
                    {vods.map((v) => (
                        <li
                            key={`${v.user_id}:${v.stream_id}:${v.recorded_at}`}
                            className="flex items-center justify-between gap-3 rounded-lg border border-neutral-700 bg-neutral-900/50 px-4 py-3"
                        >
                            <div className="min-w-0">
                                <div className="truncate font-medium text-neutral-100">{v.title}</div>
                                <div className="text-sm text-neutral-400">{v.recorded_at}</div>
                            </div>

                            <Link
                                to={`/vod/${v.user_id}/${encodeURIComponent(v.recorded_at)}`}
                                className="shrink-0 rounded-md bg-secondary px-3 py-1.5 text-sm font-medium text-neutral-900 hover:bg-primary"
                            >
                                Watch
                            </Link>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}

