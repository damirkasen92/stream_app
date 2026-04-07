import {useParams} from "react-router-dom";
import VideoPlayer from "@components/VideoPlayer/VideoPlayer.tsx";

export default function WatchStreamPage() {
    const {userId} = useParams();

    if (!userId) {
        return <p className="p-4 text-neutral-400">Invalid watch link.</p>;
    }

    return (
        <div className="mx-auto max-w-5xl p-4">
            <h1 className="mb-4 text-xl font-semibold">Live stream</h1>
            <VideoPlayer streamUrl={`/api/streams/${userId}/master.m3u8`} />
        </div>
    );
}
