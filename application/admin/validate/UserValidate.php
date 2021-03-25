<?php

namespace app\admin\validate;

use think\Validate;

class UserValidate extends Validate
{
    protected $rule =   [
        'account'  => 'require',
        'passwd'   => 'require',
        'nickName' => 'require',
        'phone' => 'require'
    ];

    protected $message  =   [
        'account.require' => '用户名不能为空',
        'passwd.require'   => '密码不能为空',
        'nickName.require'   => '昵称不能为空',
        'phone.require' => '手机号码不能为空'
    ];

    protected $scene = [
        'edit'  =>  ['account', 'nickName', 'phone']
    ];
}