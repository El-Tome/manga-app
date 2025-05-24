start:
	docker compose up -d

stop:
	docker compose down

bash:
	docker exec -ti manga-app_php bash

cc:
	docker exec manga-app_php php bin/console cache:clear

restart:
	docker compose down && \
	docker compose up -d && \
	docker exec manga-app_php php bin/console cache:clear

