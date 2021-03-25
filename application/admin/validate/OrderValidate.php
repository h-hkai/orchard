<?php

namespace app\admin\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule =   [
        'user_id'  => 'require',
        'money'   => 'require',
        'freight' => 'require',
        'buyTime' => 'require',
        'status' => 'require',
        'tracking' => 'require'
    ];

    protected $message  =   [
        'user_id.require' => '用户ID不能为空',
        'money.require'   => '金额不能为空',
        'freight.require'   => '运费不能为空',
        'buyTime.require' => '下单时间不能为空',
        'status.require' => '订单状态不能为空',
        'tracking.require' => '运单号不能为空'
    ];

    protected $scene = [
        'edit'  =>  ['user_id', 'money', 'freight', 'buyTime', 'status', 'tracking']
    ];
}