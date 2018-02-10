#!/usr/bin/env bash

echo "Starting environment in daemon mode";
docker-compose -f docker-compose.yml up -d;
