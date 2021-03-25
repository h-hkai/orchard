<?php

namespace app\admin\validate;

use think\Validate;

class CardValidate extends Validate
{
    protected $rule =   [
        'user_id'  => 'require',
        'level'   => 'require',
        'money' => 'require',
        'createTime' => 'require',
        'status' => 'require'
    ];

    protected $message  =   [
        'user_id.require' => '用户ID不能为空',
        'level.require'   => '会员等级不能为空',
        'money.require'   => '金额不能为空',
        'createTime.require' => '注册时间不能为空',
        'status.require' => '激活状态不能为空'
    ];

    protected $scene = [
        'edit'  =>  ['user_id', 'level', 'money', 'createTime', 'status']
    ];
}