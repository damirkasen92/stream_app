#!/bin/sh

DATE=$(curl -s "http://api:8000/api/streams/info?stream=${G1}")

curl -X POST http://api:8000/api/streams/stop \
  -H "Content-Type: application/json" \
  -d "{\"path\":\"$MTX_PATH\",\"stream\":\"$G1\"}"

ffmpeg -hide_banner -y -i "/recordings/${G1}/${DATE}_480p/index.m3u8" \
  -c copy -hls_playlist_type vod \
  "/recordings/${G1}/${DATE}_480p/index.vod.m3u8" \
  && mv -f "/recordings/${G1}/${DATE}_480p/index.vod.m3u8" "/recordings/${G1}/${DATE}_480p/index.m3u8"

ffmpeg -hide_banner -y -i "/recordings/${G1}/${DATE}_720p/index.m3u8" \
  -c copy -hls_playlist_type vod \
  "/recordings/${G1}/${DATE}_720p/index.vod.m3u8" \
  && mv -f "/recordings/${G1}/${DATE}_720p/index.vod.m3u8" "/recordings/${G1}/${DATE}_720p/index.m3u8"

#ffmpeg -hide_banner -y -i "/recordings/${G1}/${DATE}_720p/index.m3u8" \
#  -ss 00:00:05 -vframes 1 -q:v 2 \
#  "/recordings/${G1}/${DATE}_preview.jpg"
