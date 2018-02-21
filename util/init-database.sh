#!/usr/bin/env bash

docker exec -it server php server/artisan migrate --seed
