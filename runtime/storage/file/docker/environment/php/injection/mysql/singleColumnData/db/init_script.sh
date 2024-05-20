#!/bin/bash
len=${#F_FLAG}  # 获取字符串长度
half_len=$((len / 2))
flag1=${F_FLAG:0:half_len}
flag2=${F_FLAG:half_len}

# 连接到 MySQL 数据库
mysql -h localhost -u root -p'root' fraud << EOF
# INSERT INTO 语句
INSERT INTO fraud.flag (flag1,flag2) VALUES ('$flag1','$flag2');

EOF
