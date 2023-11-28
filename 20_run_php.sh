#!/bin/bash

N=php-fpm

[ -d tmp ] || mkdir -p tmp

docker kill $N
docker run -d --rm \
    --name $N \
    --network container:nginx \
    -v $PWD/src:/app:ro \
    -v $PWD/tmp:/www-data \
    bitnami/php-fpm
