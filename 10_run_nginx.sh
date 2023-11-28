#!/bin/bash

N=nginx
IP=127.0.0.1

docker kill $N
docker run -d --rm \
    --name $N \
    --hostname $N \
    -p $IP:8080:8080 \
    -v $PWD/src:/app \
    -v $PWD/cfg/nginx.cfg:/opt/bitnami/nginx/conf/server_blocks/my_server_block.conf:ro \
    bitnami/nginx
