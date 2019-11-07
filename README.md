Simulate MySQL Deadlock
======================================
SQLSTATE[40001]: Serialization failure: 1213 Deadlock found when trying to get lock; try restarting transaction


### Install Docker

https://docs.docker.com/docker-for-mac/install/


## Setup

```
docker-compose up -d --build
```

```
docker-compose run deadlock composer install --no-interaction \
&& docker-compose run deadlock bin/console doctrine:migrations:migrate --no-interaction \
&& docker-compose run deadlock bin/console doctrine:fixtures:load --no-interaction
```

## Run

Run
```
docker-compose run deadlock bin/console deadlock 1
```

Immediately in another terminal run

```
docker-compose run deadlock bin/console deadlock 2
```

## Teardown

```
docker-compose stop db
docker-compose rm
```
