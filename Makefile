COMPOSE=docker compose
REMOVE=docker rm php_apache phpmyadmin mysql && docker network rm localnet

up:
	$(COMPOSE) down
	$(COMPOSE) up -d

build:
	$(COMPOSE) down
	$(COMPOSE) up -d --build

down:
	$(COMPOSE) down

remove:
	$(REMOVE)
	
dump:
	docker exec -it mysql /dumpdb