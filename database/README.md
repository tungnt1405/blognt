## câu lệnh dùng cho migration hay dùng

1. `php artisan migrate:fresh` ==> tự drop table và migrate lại
   `php artisan migrate:fresh --seed` ==> tương tự câu lệnh trên nhưng tự động thực hiện thêm data seeding
2. `php artisan migrate:reset` ==> The migrate:reset command will roll back all of your application's migrations
3. `php artisan migrate:refresh` # Refresh the database and run all database seeds...
   `php artisan migrate:refresh --seed`
   The migrate:refresh command will roll back all of your migrations and then execute the migrate command. This command effectively re-creates your entire database
4. `php artisan migrate:rollback` ==> thực hiện back db trước lần migrate gần nhất
   muốn quay lại 2 bước migrate dùng `--step=số lần muốn rollback`

tham khảo: https://laravel.com/docs/10.x/migrations
