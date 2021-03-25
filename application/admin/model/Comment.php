<?php

namespace app\admin\model;

use think\Model;

class Comment extends Model
{
    protected $table = 'bsa_comment';

    /**
     * 获取产品信息
     * @param $orderId
     * @return array
     */
    public function getCommentByOrderId($orderId)
    {
        try {

            $info = $this->where('order_id', $orderId)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

}