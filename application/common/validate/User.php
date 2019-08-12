<?php

namespace app\common\validate;

use think\Validate;

class User extends Validate
{

    protected $rule = [
        'id'=>'require|number',
        'user'=>'require|max:40|alphaDash',
        'name'=>'require|max:20',
        'phone'=>'require|mobile',
        'password'=>'require|max:60',
        'integral'=>'require|max:10|number',
        'money'=>'require|float',
        'status'=>'require|number|max:11',
        'address'=>'require',
        'inv'=>'require'
    ];

    protected $field = [
        'user'=>'用户名',
        'name'=>'真实姓名',
        'phone'=>'手机号',
        'password'=>'密码',
        'integral'=>'积分',
        'status'=>'状态',
        'address'=>'地址'
    ];
    protected $scene= [
        'login'=>['user','password'],
        'add'=>['user','name','phone','password','integral','money','status','address'],
        'valStatus'=>['uid','status'],
        'valMoney'=>['uid','money'],
        'nameVal'=>['uid','name'],
        'phoneVal'=>['uid','phone'],
        'passwordVal'=>['uid','password'],
        'addressVal'=>['uid','address'],
    ];
}
