#!/bin/bash
set -e
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<-EOSQL
    CREATE DATABASE "$POSTGRES_DB";
    \c $POSTGRES_DB
    CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
EOSQL
