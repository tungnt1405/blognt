## Setup Project

1. Clone project
2. Copy file .env.example to .env or open terminal run bash

```
    cp .env.example .env
```

3. Edit information DATABASE in file .env:

-   DB_DATABASE
-   DB_USERNAME
-   DB_PASSWORD

4. Create folder storage/framework (recommended)
5. In storage/framework create folder

-   cache
-   sessions
-   views

6. Create folder storage/logs (recommended)

optional (can be added):

-   storage/app/public
-   storage/...

7. Run bash

```
php artisan migrate
```

8. Run base

```
php artisan key:generate
```
