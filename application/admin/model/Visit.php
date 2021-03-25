<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Visit extends Model
{
    protected $table = 'bsa_visit_order_form';

    /**
     * 获取订单
     * @param where
     * @return array
     */
    public function getOrders($where)
    {

        try {

            $res = Db::name('visit_order_form')->where($where)->select();

        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return $res;
    }

    /**
     * 增加产品
     * @param $product
     * @return array
     */
    public function addOrder($order)
    {
        try {

            $this->insert($order);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加订单成功');
    }

    /**
     * 编辑订单
     * @param $order
     * @return array
     */
    public function editOrder($order)
    {
        try {

            $this->save($order, ['visit_id' => $order['visit_id']]);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑订单成功');
    }

    /**
     * 通过id获取订单
     * @param $visitId
     * @return array
     */
    public function getOrderById($visitId)
    {
        try {

            $res = $this->where('visit_id', $visitId)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $res, '编辑订单成功');
    }

    /**
     * 删除订单
     *
     */
    public function delOrder($orderId) {
        try {
            $this->where('visit_id', $orderId)->delete();
        } catch (\Exception $e) {
            return modelReMsg(-1, '', $e->getMessage());
        }
        return modelReMsg(0, '', '删除成功');
    }


}