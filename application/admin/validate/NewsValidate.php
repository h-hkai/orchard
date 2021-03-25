<?php

namespace app\admin\validate;

use think\Validate;

class NewsValidate extends Validate
{
    protected $rule =   [
        'title'  => 'require',
        'type'   => 'require',
        'date' => 'require',
        'author' => 'require',
        'content' => 'require'
    ];

    protected $message  =   [
        'title.require' => '新闻标题不能为空',
        'type.require'   => '类型不能为空',
        'date.require' => '日期不能为空',
        'author.require' => '作者不能为空',
        'content' => '内容不能为空'
    ];

    protected $scene = [
        'edit'  =>  ['title', 'type', 'date', 'author', 'content']
    ];
}