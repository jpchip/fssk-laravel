
# FSSK - Laravel
> Full Stack Starter Kit Playground

Full Stack Starter Kit, but usiing PHP/Laravel for server instead of Node.

## Installing / Getting started

Copy `server/.env.example` to `server/.env` and `client/.env.example` to `client/.env`

Run the following:

```shell
docker compose up -d
```

To init the database:

```shell
docker exec -it server php server/artisan migrate --seed
```

This spins up a postgres instance, starts client at http://localhost:3000 
and starts server at http://localhost:4000. Server calls are proxied, so http://localhost:3000/api/users will hit http://localhost:4000/api/users automagically.

## Developing

### Built With

The current technologies used by fssk are as follows:

| Type | Selected Technology | Reasoning |
| ---- | ------------------- | --------- |
| Transpiler | [TypeScript](https://www.typescriptlang.org/) | Static types make for code that is less buggy and easier to reason about.  A basic TypeScript cheatsheet can be found [here](https://www.sitepen.com/blog/2013/12/31/typescript-cheat-sheet/) and more extensive documentation [here](https://www.typescriptlang.org/docs/tutorial.html) and [here](https://www.sitepen.com/blog/2013/12/31/definitive-guide-to-typescript/) |
| View Library | [React](https://facebook.github.io/react/) | Component-based views that encourage single-directional data flow |
| Client-side State Management | [MobX](https://github.com/mobxjs/mobx) | Simpler than Redux and requires less boilerplate |
| Backend Server | [Laravel](https://laravel.com/docs/5.5) | Well documented and widely supported web framework |
| API Protocol | REST | A familiar paradigm to most developers |
| Data Mapping Framework | [Eloquent ORM](https://laravel.com/docs/5.5/eloquent) | Included with Laravel |
| Database Migrations | [Laravel Migrations](https://laravel.com/docs/5.5/migrations) | Provided by Laravel, so no additional dependencies |
| Data Store | [PostgreSQL](https://www.postgresql.org/) | Open source, rock solid, industry standard |
| Package Manager | [npm](https://www.npmjs.com/) | The battle-tested choice for node development |
| Containerization | [Docker](https://www.docker.com/) | Containers make deployment easy |
| Testing Framework | [Jest](https://facebook.github.io/jest/) | Complete testing package with an intuitive syntax |
| Linter | [tslint](https://github.com/palantir/tslint) | Keeps your TypeScript code consistent |

### Prerequisites

- Docker

### Setting up Dev

See Getting Started section for steps.

### Building

Build client side code:

```shell
cd server/ && npm run build
```

A production Docker build is coming soon.

### Deploying / Publishing

Not there yet, but eventually:

```shell
docker-compose -f docker-compose-prod.yml up
```

Will build the client code, spin up the server in a docker instance with / pointing to client's index.html.

## Configuration

See the .env.example files in client and server directories.

## Tests

Client and Server code each have their own tests, using Jest.

```shell
npm test
```

and 

```shell
cd server && ./vendor/bin/phpunit
```

## Artisan

Laravel has a CLI tool called Artisan. To use it:

```shell
docker exec -it server php server/artisan YOUR_COMMAND
```

Do `list` to see available commands.

## Style guide

TBD

## Api Reference

TBD

## Database

Using postgres v9.6. For local development, database runs in docker container. `server/database` contains int script, migrations, and seeds.

Run migrations:

```shell
php artisan migrate
```

Run seeds:

```shell
php artisan db:seed
```

#### Create new seeds:

```shell
php artisan make:seeder TodosTableSeeder
```

Add it to `DatabaseSeeder.php`:

```
$this->call(TodosTableSeeder::class);
```


## How to make a new API endpoint

- Make Model and DB Migration:

```
php artisan make:model Todo -m
```

-  Make Controller:

```
php artisan make:controller TodoController --resource --model=Todo
```

-  Add Routes

```
Route::apiResource('todos', 'TodoController');
```

-  Add Authorization Policies:

```
php artisan make:policy TodoPolicy --model=Todo
```

Register policy in `AuthServiceProvider`:

```
Todo::class => TodoPolicy::class,
```

## Licensing

[MIT License](LICENSE.md)
