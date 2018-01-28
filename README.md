
# FSSK - Laravel
> Full Stack Starter Kit Playground

Trying Laravel for server

## Installing / Getting started

Run the following:

```shell
docker compose up -d
```

To Bring up shell:

```shell
docker exec -it server bash
cd server
```

To init the database:

```shell
php artisan migrate --seed
```



## Database

Run migrations:

```shell
php artisan migrate
```

Run seeds:

```shell
php artisan db:seed
```

Create new seeds:

```shell
php artisan make:seeder TodosTableSeeder
```

Add it to the `DatabaseSeeder.php`:

```
$this->call(TodosTableSeeder::class);
```


## How to make a new API endpoint

1. Make Model and DB Migration:

php artisan make:model Todo -m

2. Make Controller:

php artisan make:controller TodoController --resource --model=Todo

3. Add Routes

Route::apiResource('todos', 'TodoController');


 
