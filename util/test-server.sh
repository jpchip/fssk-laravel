#!/usr/bin/env bash

docker exec -it server cd server && ./vendor/bin/phpunit
