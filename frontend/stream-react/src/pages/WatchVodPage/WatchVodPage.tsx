import {useParams} from "react-router-dom";
import VideoPlayer from "@components/VideoPlayer/VideoPlayer.tsx";

export default function WatchVodPage() {
    const {userId, recordedAt} = useParams();

    if (!userId || !recordedAt) {
        return <p className="p-4 text-neutral-400">Invalid VOD link.</p>;
    }

    const decodedRecordedAt = decodeURIComponent(recordedAt);

    return (
        <div className="mx-auto max-w-5xl p-4">
            <h1 className="mb-4 text-xl font-semibold">VOD</h1>
            <VideoPlayer streamUrl={`/api/vods/${userId}/${decodedRecordedAt}/master.m3u8`} />
        </div>
    );
}

