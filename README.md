# contained-php

Nginx and PHP in container made simple.

Command to store JSON values:

```bash
curl -X POST "0:8080/short/?uuid=2db9cd01-e909-448d-8883-93e2773657a7" --data '{"keyA":"valA","sub":{"keyB":"valB"}}'
```

Command to retrieve JSON values:

```bash
curl "0:8080/short/?uuid=2db9cd01-e909-448d-8883-93e2773657a7"
```

or the ultimate no `?` and `=` containing url

```bash
curl "0:8080/short/2db9cd01-e909-448d-8883-93e2773657a7"
```

## To test yourself

just run (with docker installed):

```bash
# to download and start nginx frontend server
./10_run_nginx.sh
# to start php-fpm backend server (used by enginx)
./20_run_php.sh
```

The go to <http://localhost:8080> beware that the port `8080` has to be available in order to start.
