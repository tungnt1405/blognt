## 1 số lưu ý dùng centos trên local

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
