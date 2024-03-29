## Setup Project

1. Clone project
2. Copy file .env.example to .env or open terminal run bash

```
    cp .env.example .env
```

copy file vite.config.js.example to vite.config.js or run bash

```
cp vite.config.js.example vite.config.js
```

3. Edit information DATABASE in file .env:

-   DB_DATABASE
-   DB_USERNAME
-   DB_PASSWORD

4. Create folder storage/ và storage/framework (recommended)
5. In storage/framework create folder

-   storage/framework/cache
-   storage/framework/sessions
-   storage/framework/views

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

## other configuration

1. Copy file vite.config.js

```javascript
laravel({
    input: [
        'resources/assets/js/frontend/app.js',
        'resources/assets/js/backend/admin/main.js',
        'resources/assets/js/backend/admin/common.js',
        'resources/assets/js/backend/admin/onwer.js',
        'resources/assets/js/backend/admin/posts.js',
        'resources/assets/scss/admin/main.scss',
        'resources/assets/scss/main.scss',
    ],
    refresh: [...refreshPaths, 'app/Http/Livewire/**'],
}),
vue(),
{
    name: 'blade',
    handleHotUpdate({ file, server }) {
        if (file.endsWith('.blade.php')) {
            server.ws.send({
                type: 'full-reload',
                path: '*',
            });
        }
    },
},

```

2. Do lưu trữ file img upload của post ở storage nên cần run 
```
php artisan storage:link
``` 
để có thể tạo liên kết giữa `public/storage` và `storage/app/public`.
