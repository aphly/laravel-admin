**laravel 后台管理**<br>

环境<br>
php8.0+<br>
laravel9.0+<br>
mysql5.7+<br>

安装<br>
`composer require aphly/laravel-admin` <br>
`php artisan vendor:publish --provider="Aphly\LaravelAdmin\AdminServiceProvider"` <br>
`php artisan migrate` <br>

1、config/auth.php<br>
数组guards中 添加<br> 
`'manager' => [
'driver' => 'session',
'provider' => 'manager'
]`
<br>数组providers中 添加<br>
`'manager' => [
'driver' => 'eloquent',
'model' => Aphly\LaravelAdmin\Models\Manager::class
]`

2、`www.xxxx.com/admin/init` 初始化 管理员帐户:admin 密码:admin

3、初始化完成后，将配置文件 config/admin.php  init设置为false

4、`www.xxxx.com/admin/login` 后台登录地址

小技巧<br>
1、 数据库迁移报错 app/Providers/AppServiceProvider.php boot()中 添加 `Schema::defaultStringLength(191);`<br>
2、 `composer dump-autoload`<br>
3、 `php artisan storage:link`<br>
4、 后台不显示清下缓存<br>
5、`php artisan config:cache`<br>
6、`php artisan route:cache`<br>
7、`php artisan view:cache`<br>

![image](https://github.com/aphly/laravel-admin/blob/main/logo.png)
因和谐原因，如果图片不显示，请修改本地hosts
