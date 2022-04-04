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
php artisan l5-swagger:generate
```
mail account ([mailtrap](https://mailtrap.io/) for development/testing)

API documentation: /api/documentation

## Run Tests
```
phpunit tests
```

## API methods
```
  GET|HEAD        api/item-category
  GET             api/item-category/my
  POST            api/item-category
  GET|HEAD        api/item-category/{item_category}
  PUT|PATCH       api/item-category/{item_category}
  DELETE          api/item-category/{item_category}
  -------
  GET|HEAD        api/collect-point
  POST            api/collect-point
  GET|HEAD        api/collect-point/{collect_point}
  PUT|PATCH       api/collect-point/{collect_point}
  DELETE          api/collect-point/{collect_point}
  -------
  POST            api/login
  GET            api/logout

```