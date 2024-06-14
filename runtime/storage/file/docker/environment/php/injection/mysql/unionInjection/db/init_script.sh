#!/bin/bash
# 连接到 MySQL 数据库
mysql -h localhost -u root -p'root' fraud << EOF
# INSERT INTO 语句
INSERT INTO fraud.flag (flag) VALUES ('$F_FLAG');

EOF
