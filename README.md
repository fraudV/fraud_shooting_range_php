fruad_shooting_range_php
===============

## 开源项目

* fraud系列web靶场
* fraud系列cve挖掘

## 系统安装
推荐环境
~~~
ubuntu 20.04
PHP 7.2.21
mysql 8.0.16
建议直接使用phpstudy-linux搭建环境
~~~
源码下载
~~~
https://github.com/telllieV/fraud_shooting_range_php.git
~~~

进入目录
~~~
cd fraud_shooting_range_php
~~~
下载PHP依赖包（文件所在根目录执行如下命令）
~~~
composer install
~~~
导入数据库文件
~~~
db/fraud.sql
~~~
安装docker，环境使用是**docker compose** 命令启动，不支持**docker-compose**
~~~
curl -s https://get.docker.com/ | sh 
~~~
第一次启动环境需要编译下载镜像，所有启动较慢
## 项目展示
![1716207804731.jpg](img%2F1716207804731.jpg)
![1716207817392.jpg](img%2F1716207817392.jpg)
## 参与开发

开发者：fraud

## 版权信息

fraud系列
