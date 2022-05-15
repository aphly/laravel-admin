**laravel 后台管理**<br>

环境<br>
php7.3+<br>
laravel8.37+<br>
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
],'user' => [
'driver' => 'session',
'provider' => 'user'
]`
<br>数组providers中 添加<br>
`'manager' => [
'driver' => 'eloquent',
'model' => Aphly\LaravelAdmin\Models\Manager::class
],'user' => [
'driver' => 'eloquent',
'model' => \Aphly\LaravelAdmin\Models\User::class
]`

2、`www.xxxx.com/admin/init` 初始化 管理员帐户:admin 密码:admin

3、初始化完成后，将配置文件 config/admin.php  init设置为false

4、`www.xxxx.com/admin/login` 后台登录地址


![image](https://v.apixn.com/logo.png)
