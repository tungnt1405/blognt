## 1 số lệnh command dùng cho môi trường

1. tail -f file: xem log real-time của file log
2. htop hoặc top: xem tiến trình sử dụng hệ thống như cpu, ram, disk (như task manager win)
3. free: xem dung lượng còn thừa của ổ cứng
4. service service_using restart|start|stop hoặc systemctl restart|start|stop service_using: khởi động lại|Khởi động|Dừng các dịch vụ đang sử dụng
5. chmod -R 777|755 file: cấp full quyền đọc ghi|cấp quyền đọc ghi
6. chown -R quyền file: httpd|nginx|$USER|root cấp quyền user sẽ đọc ghi file.
7. Và 1 số lệnh khác: cd, touch, cp, mkdir, ...

## Một số lỗi gặp phải khi dùng centos 7 đã gặp

==> run watch password root

grep 'temporary password' /var/log/mysqld.log

==>run command để thao tác với mysql background

mysql -u root -p

==> check file /var/lib/mysql/localhost.log để xem log mysql

Tham khảo:
https://www.herongyang.com/MySQL/Linux-Server-Log-Files-on-CentOS.html

timezone:
https://serverfault.com/questions/368602/how-do-i-update-a-centos-servers-time-from-an-authoritative-time-server

sudo setsebool httpd_can_network_connect_db 1

update datetime: https://serverfault.com/questions/368602/how-do-i-update-a-centos-servers-time-from-an-authoritative-time-server

`yum install ntp`
`ntsysv` or `chkconfig ntpd on`

// update lại time cho server
`ntpdate time.apple.com`

## fix lỗi Permission denied

cd /var/www/laravelfolder

sudo chown apache:apache -R /var/www/laravelfolder

find . -type f -exec chmod 0644 {} \;

find . -type d -exec chmod 0755 {} \;

sudo chcon -t httpd_sys_content_t /var/www/laravelfolder -R

sudo chcon -t httpd_sys_rw_content_t /var/www/laravelfolder/storage -R

sudo chcon -t httpd_sys_rw_content_t /var/www/laravelfolder/bootstrap/cache -R

tham khảo: https://stackoverflow.com/questions/44533090/laravel-failed-to-open-stream-permission-denied

**hoặc**

Nếu gặp lỗi `SQLSTATE[HY000] [2002] Permission denied` hãy chạy
`setsebool -P httpd_can_network_connect 1`
hoặc
`setsebool -P httpd_can_network_connect_db 1`

sau đó restart http
`service httpd restart`
hoặc dùng nginx
`service nginx restart`

và restart mysql
`service mysqld restart`
