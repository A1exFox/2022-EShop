COMPOSE=docker compose

up:
	$(COMPOSE) down
	$(COMPOSE) up -d
build:
	$(COMPOSE) down
	$(COMPOSE) up -d --build
down:
	$(COMPOSE) down