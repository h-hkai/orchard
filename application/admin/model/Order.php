<?php

namespace app\admin\model;

use app\admin\model\Order as orderModel;
use app\admin\model\Product as productModel;
use app\admin\model\User as userModel;
use think\Model;
use think\Db;

class Order extends Model
{
    protected $table = 'bsa_order_form';

    /**
     * 获取订单
     * @param $where
     * @return array
     */
    public function getOrders($where)
    {

        try {

            $res = Db::name('order_form')->where($where)->select();

        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return $res;
    }

    /**
     * 增加订单
     * @param $order
     * @return array
     */
    public function addOrder($order)
    {
        try {

            $has = $this->where('tracking', $order['tracking'])->findOrEmpty()->toArray();
            if(!empty($has)) {
                return modelReMsg(-2, '', '运单已存在');
            }

            $this->insert($order);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加订单成功');
    }

    /**
     * 获取订单信息
     * @param $orderId
     * @return array
     */
    public function getOrderById($orderId)
    {
        try {

            $info = $this->where('order_id', $orderId)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

    /**
     * 编辑产品
     * @param $order
     * @return array
     */
    public function editOrder($order)
    {
        try {

            $has = $this->where('tracking', $order['tracking'])->where('tracking', '<>', $order['tracking'])
                ->findOrEmpty()->toArray();
            if(!empty($has)) {
                return modelReMsg(-2, '', '运单已存在');
            }

            $this->save($order, ['order_id' => $order['order_id']]);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑订单成功');
    }

    /**
     * 删除产品
     * @param $orderId
     * @return array
     */
    public function delOrder($orderId)
    {
        try {
            $this->where('order_id', $orderId)->delete();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '删除成功');
    }
    /**
     * 获取用户名
     * @param $orderId
     * @return string
     */
    public function getUserAccountByOrderId($orderId) {
        $order = new orderModel();
        $orderRes = $order->getOrderById($orderId);
        $userId = $orderRes['data']['user_id'];
        $user = new userModel();
        $userRes = $user->getUserById($userId);
        return $userRes['data']['account'];
    }
    /**
     * 获取上商品名
     * @param $orderId
     * @return string
     */
    public function getProductNameByOrderId($orderId) {
        $order = new orderModel();
        $orderRes = $order->getOrderById($orderId);
        $productId = $orderRes['data']['product_id'];
        $product = new productModel();
        $productRes = $product->getProductById($productId);
        return $productRes['data']['product_name'];
    }
}