# 使用官方 PHP 镜像作为基础镜像
FROM php:7.4.0-apache

# 将 /var/www/html 设为工作目录
WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y iputils-ping