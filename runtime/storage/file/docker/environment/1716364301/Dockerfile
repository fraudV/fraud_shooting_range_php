# 使用官方 PHP 镜像作为基础镜像
FROM php:7.4.0-apache

# 将 /var/www/html 设为工作目录
WORKDIR /var/www/html

# 启用 mysqli 扩展
RUN docker-php-ext-install mysqli

# 启动 Apache 服务
CMD ["apache2-foreground"]

