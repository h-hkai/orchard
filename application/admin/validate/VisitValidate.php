<?php

namespace app\admin\validate;

use think\Validate;

class VisitValidate extends Validate
{
    protected $rule =   [
        'user_id'  => 'require',
        'project_id'   => 'require',
        'money' => 'require',
        'create_time' => 'require',
    ];

    protected $message  =   [
        'user_id.require' => '用户ID不能为空',
        'project_id.require'   => '金额不能为空',
        'money.require' => '下单时间不能为空',
        'create_time.require' => '订单状态不能为空',
    ];

    protected $scene = [
        'edit'  =>  ['user_id', 'project_id', 'money', 'create_time']
    ];
}