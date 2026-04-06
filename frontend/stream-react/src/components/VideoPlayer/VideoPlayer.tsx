import {useEffect, useRef} from "react";
import Hls from "hls.js";

export default function VideoPlayer({streamUrl}: {streamUrl: string}) {
    const videoRef = useRef<HTMLVideoElement>(null);

    useEffect(() => {
        if (!videoRef.current) return;

        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(streamUrl);
            hls.attachMedia(videoRef.current);
        } else if (videoRef.current.canPlayType("application/vnd.apple.mpegurl")) {
            videoRef.current.src = streamUrl;
        }
    }, [streamUrl]);

    return <video ref={videoRef} controls autoPlay muted className={"w-full aspect-video"} />;
}
