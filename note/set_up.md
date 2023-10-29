Hướng dẫn cài full core: backend, fontend, socket

đầu tiên: `docker network create --driver bridge blognt` để tạo network chung

1. backend
+ set up như README của backend
+ tại file .env (đã copy từ .env.example) thì sẽ update
```bash
APP_ENV=production/local #tùy vào đang setting môi trường nào
...
APP_URL=http://domain #htttps://domain
APP_SERVICE="domain"
...
LOG_CHANNEL=daily
...
DB_HOST=mariadb
....
DB_USERNAME=blognt
DB_PASSWORD=admin@!2023 #hoặc có thể general online
BROADCAST_DRIVER=redis
QUEUE_CONNECTION=redis
...
REDIS_HOST=redis
...
VITE_SOCKET_SERVER=domain-socket #ví dụ http://localhost:3002

# còn lại tùy thuộc vào setting
```
+ sau đó cài composer
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

hoặc cài trực tiếp php và composer tại máy thật và chạy `composer install --ignore-platform-reqs`

<strong>chạy với product thì `composer install --ignore-platform-reqs --no-autoloader --no-dev --no-interaction --no-progress --no-suggest --no-scripts --prefer-dist`</strong>

+ sau đó cài nodemodules
```bash
./vendor/bin/sail up -d

#done build docker
./vendor/bin/sail shell # để mở termiral docker

# sau khi vào termial trong docker
yarn # hoặc `npm install` / `npm install --production`
```

+ run migrate
```bash
php artisan key:generate
php artisan migrate --seed

yarn build # develop `yarn dev`
```

2. fontend
- install nodemodules
- chạy lệnh để dùng (chưa viết docker) nên sẽ chạy thủ công

3. socket
- install nodemodules
- chạy 
```bash
docker run --rm \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    node:18-alpine \
    npm install

# không chắc nhưng thử làm mới hoàn toàn: -u "$(id -u):$(id -g)" \ add vào sau --rm xem chạy không =))
# set lại quyền
sudo chown -R $USER:$USER .

# chạy docker
docker compose up -d
```

ngoải ra chạy tại môi trường gốc