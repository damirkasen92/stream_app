#!/bin/sh

curl -X POST http://api:8000/api/streams/stop \
  -H "Content-Type: application/json" \
  -d "{\"path\":\"$MTX_PATH\",\"stream\":\"$G1\"}"
