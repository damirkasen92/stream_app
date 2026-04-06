import {useParams} from "react-router-dom";
import VideoPlayer from "@components/VideoPlayer/VideoPlayer.tsx";

export default function StreamPreview() {
    const {id} = useParams();

    return (
        <div>
            <div className="stream-preview">Предпросмотр стрима №{id}</div>

            <VideoPlayer streamUrl={`/api/streams/${id}/master.m3u8`} />
            {/*<VideoPlayer streamUrl={`http://localhost:8888/live480p/ZoucaQq0AIUnd4cypelO4QFhKbAED0ce/main_stream.m3u8`} />*/}
        </div>
    );
}
