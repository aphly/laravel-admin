**laravel 后台管理**<br>

环境<br>
php8.1+<br>
laravel10.0+<br>
mysql5.7+<br>

安装<br>
`composer require aphly/laravel-admin` <br>
`php artisan vendor:publish --provider="Aphly\LaravelAdmin\AdminServiceProvider"` <br>
`php artisan migrate` <br>

需要oss 请自行添加<br>
`"require": {
"aliyuncs/oss-sdk-php": "~2.4"
}`<br>

1、config/auth.php<br>
数组guards中 添加<br> 
`'manager' => [
'driver' => 'session',
'provider' => 'manager'
]`
<br>数组providers中 添加<br>
`'manager' => [
'driver' => 'eloquent',
'model' => Aphly\Laravel\Models\Manager::class
]`

2、`www.xxxx.com/admin/init` 初始化

3、初始化完成后，将配置文件 config/admin.php  init设置为false

4、`www.xxxx.com/admin/login` 后台登录地址

