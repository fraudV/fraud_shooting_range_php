# 使用官方 PHP 镜像作为基础镜像
FROM php:7.4.0-apache

# 将 /var/www/html 设为工作目录
WORKDIR /var/www/html

# 安装 PDO 的 MySQL 驱动
RUN docker-php-ext-install pdo_mysql

# 启用 Apache 的 rewrite 模块，以便使用 .htaccess 文件
RUN a2enmod rewrite

# 启动 Apache 服务器
CMD ["apache2-foreground"]