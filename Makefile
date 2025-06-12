PHP=docker compose run --rm php

install:
	$(PHP) composer install

test:
	$(PHP) vendor/bin/phpunit
