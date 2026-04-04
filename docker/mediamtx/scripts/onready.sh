#!/bin/sh
DATE=$(date +%Y-%m-%d_%H-%M-%S)

code=$(curl -s -o /dev/null -w "%{http_code}" \
  -X POST http://api:8000/api/streams/start \
  -H "Content-Type: application/json" \
  -d "{
    \"stream\":\"$G1\",
    \"path\":\"$MTX_PATH\",
    \"conn_id\":\"$MTX_SOURCE_ID\",
    \"vod_paths\": [\"/recordings/${G1}/${DATE}_480p/index.m3u8\", \"/recordings/${G1}/${DATE}_720p/index.m3u8\"],
    \"qualities\": [\"480p\", \"720p\"],
    \"recorded_at\": \"${DATE}\"
  }")

echo "App API returned $code"

if [ "$code" -ne 200 ]; then
  echo "Kicking RTMP connection $MTX_SOURCE_ID"
  curl -s -X POST -u admin:secret "http://mediamtx:9997/v3/rtmpconns/kick/$MTX_SOURCE_ID"
  exit 1
fi

mkdir -p /recordings/${G1}/${DATE}_480p
mkdir -p /recordings/${G1}/${DATE}_720p

ffmpeg -i rtmp://localhost:1935/$MTX_PATH \
  -c:v libx264 -b:v 1200k -s 854x480 -c:a aac -b:a 128k \
    -f flv rtmp://localhost:1935/live480p/$G1 \
    -c:v libx264 -b:v 1200k -s 854x480 -c:a aac -b:a 128k \
    -f hls -hls_time 6 -hls_playlist_type vod \
    /recordings/${G1}/${DATE}_480p/index.m3u8 \
  -c:v libx264 -b:v 2500k -s 1280x720 -c:a aac -b:a 128k \
    -f flv rtmp://localhost:1935/live720p/$G1 \
    -c:v libx264 -b:v 2500k -s 1280x720 -c:a aac -b:a 128k \
    -f hls -hls_time 6 -hls_playlist_type vod \
    /recordings/${G1}/${DATE}_720p/index.m3u8

exit 0