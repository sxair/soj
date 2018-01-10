# soj

### 安装

本系统使用laravel框架，需要如下php软件
* PHP >= 7.0.0
* PHP OpenSSL 扩展
* PHP PDO 扩展
* PHP Mbstring 扩展
* PHP Tokenizer 扩展
* PHP XML 扩展
* PHP ZIP拓展

安装composer和nodejs后运行
```
composer install
npm install
npm run prod
```
之后复制.env.example文件为.env。运行
```
php artisan key:generate
```

数据库表：
```
php artisan migrate:refresh
```
创建管理员用户请输入
```
php artisan db:seed
```
如需测试样例请输入
```
php artisan db:seed --class=TestSeeder
```

队列安装
```
sudo apt-get install supervisor
cp laravel_worker.conf /etc/supervisor/conf.d
```
使用
```
sudo supervisorctl start laravel-worker:*
```
来启动队列

判题端请看https://github.com/sxair/online-judge


### 展示

![soj](https://github.com/sxair/soj/blob/master/photo/soj.png?raw=true)
由于采用slideout.js 所以在移动端也有良好的体验

![soj](https://github.com/sxair/soj/blob/master/photo/soj-media.png?raw=true)
![soj](https://github.com/sxair/soj/blob/master/photo/soj-admin.png?raw=true)
