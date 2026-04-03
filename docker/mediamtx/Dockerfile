FROM bluenviron/mediamtx:latest AS mediamtx
FROM ubuntu:24.04

COPY --from=mediamtx /mediamtx /
COPY --from=mediamtx /mediamtx.yml /

RUN apt update && apt install -y \
  curl \
  ffmpeg

COPY ./docker/mediamtx/scripts/ /scripts/
RUN chmod +x /scripts/*.sh

RUN mkdir -p /recordings && \
    chmod 755 recordings

ENTRYPOINT [ "/mediamtx" ]
