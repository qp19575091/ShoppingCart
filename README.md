
------------
This is a sample API for `ShoppingCart ` use JWT authorization

Installation
------------


```
composer install
```

Then create .env file and edit database credentials there

```
cp .env.example .env
```
After run command you can find .env has copy from .env.example

Then generate APP_KEY
```
php artisan key:generate
```
After run command you can find APP_KEY in .env file has created

Create JWT key
```
php artisan jwt:secret
```

Final migrate database table. if want to seed some data you can add "--seed" after the command line
```
php artisan migrate
```

Start serve
```
php artisan serve
```
Then [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api) will work.

Start
-----
 ### You also can see `api doc` [here](http://localhost/ShoppingCart/public/docs/index.html)



