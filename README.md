# Todo App

![](images/screen.png)

# Install

```
git clone git@github.com:daiarock/todo-app.git
cd todo-app

composer install
yarn install

yarn run watch
cp .env.example .env
php argisan key:generate
php artisan migrate
php artisan seed
php artisan serve
```

Go to http://localhost:8000