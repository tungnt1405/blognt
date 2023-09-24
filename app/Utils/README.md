## Đây là một số hàm Redis thường được sử dụng trong Laravel:

1. set: Đặt một giá trị cho một key.
2. get: Lấy giá trị của một key.
3. exists: Kiểm tra xem một key có tồn tại trong Redis không.
4. del: Xóa một key.
5. incr: Tăng giá trị của một key.
6. decr: Giảm giá trị của một key.
7. hmset: Đặt nhiều giá trị cho một hash.
8. hgetall: Lấy tất cả các giá trị trong một hash.
9. lpush: Thêm một giá trị vào đầu một list.
10.rpush: Thêm một giá trị vào cuối một list.
11.lrange: Lấy một phạm vi các giá trị từ một list.
12.sadd: Thêm một giá trị vào một set.
13.smembers: Lấy tất cả các giá trị trong một set.
14.zadd: Thêm một giá trị vào một sorted set.
15.zrange: Lấy một phạm vi các giá trị từ một sorted set.


## ...$args
...$args: các phần tử khác trong mảng $content được truyền vào dưới dạng các phần tử riêng biệt trong mảng này bằng cách sử dụng toán tử ..., giúp đảm bảo rằng các phần tử này cũng sẽ được bao gồm trong nội dung JSON của phản hồi HTTP.

ví dụ: CommonUtil::responeJson
Với cách viết trong json(), nếu mảng $content chứa các phần tử khác ngoài 'code' và 'data', chúng sẽ được tự động đưa vào nội dung JSON của phản hồi HTTP.
