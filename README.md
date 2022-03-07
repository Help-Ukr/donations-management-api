# Help 4 Ukraine

## Getting Started
```
composer install
cp .env.example .env
```
setup variables:
- APP_URL
- DB_CONNECTION
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

```
php artisan migrate
php artisan key:generate
```
mail account ([mailtrap](https://mailtrap.io/) for development/testing)

## Run Tests
```
phpunit tests
```

## API methods
```
  GET|HEAD        api/item-category
  POST            api/item-category
  GET|HEAD        api/item-category/{item_category}
  PUT|PATCH       api/item-category/{item_category}
  DELETE          api/item-category/{item_category}
  -------
  POST            api/login
  POST            api/register
  POST            api/forgot-password

```