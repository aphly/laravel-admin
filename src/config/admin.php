<?php
return [
    'init'=>true, //允许初始化
    'name'=>'管理中心',
    'perPage'=>'10',
    //全局邮件开关
    'mail_status'=>true,
    //跨越
    'cross' => [
        'http://localhost'
    ],
    //图片验证码
    'seccode_login'=>2, //0 1 2
    'seccode_register'=>1, //0 1
    'seccode_forget'=>1, //0 1
    'seccode_admin_login'=>1, //0 1
];
