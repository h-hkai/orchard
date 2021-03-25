<?php

namespace app\admin\validate;

use think\Validate;

class ProductValidate extends Validate
{
    protected $rule =   [
        'product_name'  => 'require',
        'stock'   => 'require',
        'price' => 'require',
        'typeId' => 'require',
        'saleStatus' => 'require'
    ];

    protected $message  =   [
        'product_name.require' => '商品名称不能为空',
        'stock.require'   => '库存不能为空',
        'price.require'   => '价格不能为空',
        'typeId.require' => '类型不能为空',
        'saleStatus.require' => '销售状态不能为空'
    ];

    protected $scene = [
        'edit'  =>  ['product_name', 'stock', 'price', 'typeId', 'saleStatus']
    ];
}