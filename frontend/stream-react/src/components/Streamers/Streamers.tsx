import {Link} from "react-router-dom";

export type LiveStreamer = {
    id: number;
    name: string;
    avatar_url: string | null;
    streams: {
        id: number;
        title: string;
        description: string | null;
        status: string;
    }[];
};

type Props = {
    streamers: LiveStreamer[];
    loading: boolean;
    error: string | null;
};

export default function Streamers({streamers, loading, error}: Props) {
    if (loading) {
        return <p className="text-neutral-400">Loading live streamers...</p>;
    }

    if (error) {
        return <p className="text-red-400">{error}</p>;
    }

    if (streamers.length === 0) {
        return <p className="text-neutral-400">No one is live right now.</p>;
    }

    return (
        <section className="streamers flex flex-col gap-4">
            <h2 className="text-lg font-semibold">Live now</h2>
            <ul className="flex flex-col gap-3">
                {streamers.map((user) => {
                    const stream = user.streams[0];
                    if (!stream) {
                        return null;
                    }
                    return (
                        <li
                            key={user.id}
                            className="flex flex-wrap items-center gap-3 rounded-lg border border-neutral-700 bg-neutral-900/50 px-4 py-3"
                        >
                            {user.avatar_url ? (
                                <img
                                    src={user.avatar_url}
                                    alt={user.name}
                                    className="h-12 w-12 shrink-0 rounded-full object-cover"
                                />
                            ) : (
                                <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-neutral-700 text-sm font-medium text-neutral-300">
                                    {user.name.slice(0, 1).toUpperCase()}
                                </div>
                            )}
                            <div className="min-w-0 flex-1">
                                <div className="font-medium text-neutral-100">{user.name}</div>
                                <div className="truncate text-sm text-neutral-400">{stream.title}</div>
                            </div>
                            <Link
                                to={`/watch/${user.id}`}
                                className="shrink-0 rounded-md bg-primary-100 px-3 py-1.5 text-sm font-medium text-neutral-900 hover:bg-white"
                            >
                                Watch
                            </Link>
                        </li>
                    );
                })}
            </ul>
        </section>
    );
}
