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
`ntpdate time.apple.com`

## fix permission denied

cd /var/www/laravelfolder

sudo chown apache:apache -R /var/www/laravelfolder

find . -type f -exec chmod 0644 {} \;

find . -type d -exec chmod 0755 {} \;

sudo chcon -t httpd_sys_content_t /var/www/laravelfolder -R

sudo chcon -t httpd_sys_rw_content_t /var/www/laravelfolder/storage -R

sudo chcon -t httpd_sys_rw_content_t /var/www/laravelfolder/bootstrap/cache -R

tham khảo: https://stackoverflow.com/questions/44533090/laravel-failed-to-open-stream-permission-denied
