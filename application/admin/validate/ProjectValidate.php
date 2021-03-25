<?php

namespace app\admin\validate;

use think\Validate;

class ProjectValidate extends Validate
{
    protected $rule =   [
        'name'  => 'require',
        'description'   => 'require',
        'money' => 'require',
        'create_time' => 'require',
    ];

    protected $message  =   [
        'name.require' => '用户ID不能为空',
        'description.require'   => '金额不能为空',
        'money.require'   => '运费不能为空',
        'create_time.require' => '下单时间不能为空',
    ];

    protected $scene = [
        'edit'  =>  ['name', 'description', 'money', 'create_time']
    ];
}