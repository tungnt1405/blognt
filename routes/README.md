## Run command if route not working

> ** Cách 1: xóa các cache trong bootstrap/cache/routes.php **

```
php artisan route:clear
```

> ** Cách 2 **
> Lệnh php artisan optimize:clear trong Laravel được sử dụng để xóa các tập tin cache của ứng dụng, bao gồm các tập tin cache bộ nhớ đệm (cache), tập tin cache tổng hợp (compiled) và tập tin cache route (route).

Cụ thể, khi chạy lệnh này Laravel sẽ xóa các mục sau:

Các tập tin cache bộ nhớ đệm (cache) được lưu trữ trong thư mục /bootstrap/cache.
Các tập tin cache tổng hợp (compiled) được lưu trữ trong thư mục /storage/framework/.
Các tập tin cache route được lưu trữ trong thư mục /bootstrap/cache/routes.php.
Sau khi chạy lệnh này, Laravel sẽ tái tạo lại các tập tin cache trên khi có request mới vào. Lưu ý rằng việc xóa các tập tin cache này có thể làm chậm ứng dụng trong quá trình khởi động hoặc xử lý request đầu tiên.

```
php artisan optimize:clear
```
