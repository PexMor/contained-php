# contained-php

Nginx and PHP in container made simple.

> Note: url `0:8080` is shorthand of `http://127.0.0.1:8080`

Command to store JSON values (note lines wrapped):

```bash
curl -X POST "0:8080/short/?uuid=2db9cd01-e909-448d-8883-93e2773657a7" \
--data '{"keyA":"valA","sub":{"keyB":"valB"}}'
```

Command to retrieve JSON values:

```bash
curl "0:8080/short/?uuid=2db9cd01-e909-448d-8883-93e2773657a7"
```

do the same in browser like <http://127.0.0.1:8080/short/?uuid=2db9cd01-e909-448d-8883-93e2773657a7>

or the ultimate no `?` and `=` containing url

```bash
curl "0:8080/short/2db9cd01-e909-448d-8883-93e2773657a7"
```

alternative date update:

```bash
curl -X POST "0:8080/short/2db9cd01-e909-448d-8883-93e2773657a7" \
--data '{"keyA":"valA","sub":{"keyB":"valB"}}'
```

which in turn is this **cute** link <http://127.0.0.1:8080/short/2db9cd01-e909-448d-8883-93e2773657a7>

## To test yourself

There are several option how to quickly run multiple containers that depends one on another.
As the primary processes that has to be containerised are `nginx` and `php-fpm` we need two containers.
Of course the ultimate solution would be to use Kubernetes (K8s) either small like `k3`, `minicube` or
those that are part of `Docker Desktop` or hosted like `GKE` or `OpenShift` (self hosted as `OKD`).

### Simple plain docker

The bare bones setup that uses the trick of `--network container:...` so you can just run (with docker installed):

```bash
# to download image and start nginx frontend server
./10_run_nginx.sh
# to download image start php-fpm backend server (used by nginx)
./20_run_php.sh
```

### With help of docker-compose

The no-so-loved `docker-compose` Python wrapper for Docker engine can simplify some infra setup.

```bash
docker-compose up
```

Images used:

- `bitnami/nginx` - bitnami built `nginx`
- `bitnami/php-fpm` - and accompanying `php`

The go to <http://localhost:8080> beware that the port `8080` has to be available in order to start.
