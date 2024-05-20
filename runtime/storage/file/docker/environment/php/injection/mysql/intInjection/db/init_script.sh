#!/bin/bash
# 连接到 MySQL 数据库
mysql -h localhost -u root -p'root' fraud << EOF

# INSERT INTO 语句
INSERT INTO fraud.users VALUES (400,'flag','$F_FLAG','2024-05-09 12:04:25','2024-05-09 12:04:25');

EOF