## Installation:

- Clone the repository
- Run `docker-compose up -d` to build and start containers
- Wait a while
- When all dependencies've been installed please make a few steps manually (configure env vars, create DB, load fixtures) via following commands:
```
$ cp .env .env.local
$ nano .env.local
```
_There is a bug, some naming conflict. As a workaround please run at this step `docker exec -it fpm rm -rf /app/var/cache`_
```
$ docker exec -it fpm /app/bin/console doctrine:database:create
$ docker exec -it fpm /app/bin/console doctrine:migrations:migrate -n
$ docker exec -it fpm /app/bin/console doctrine:fixtures:load -n
```

## Endpoints:

- Get paginated users list
```
$ curl -X GET http://0.0.0.0:8090/user/list -u User_{{01-10}}:pass
```

- Get user account (allow to checkout account balance)
```
$ curl -X GET http://0.0.0.0:8090/user/me -u User_{{01-10}}:pass
```

- Get paginated transactions log
```
$ curl -X GET http://0.0.0.0:8090/transaction/log -u User_{{01-10}}:pass
```

- Transfer points to another user
```
$ curl -X POST http://0.0.0.0:8090/transaction -u User_{{01-10}}:pass -d '{"target_user_id": "{{user_uuid}}", "amount": 10}' -H "Content-Type: application/json"
```