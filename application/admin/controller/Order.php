<?php

namespace app\admin\controller;

use app\admin\model\Order as orderModel;
use app\admin\model\User as userModel;
use app\admin\model\Product as productModel;
use app\admin\model\Comment as commentModel;

use app\admin\validate\OrderValidate;
use think\Exception;
use tool\Log;

class Order extends Base
{
    // 产品列表
    public function index()
    {
        if(request()->isAjax()) {

            $tracking = input('param.tracking');

            $where = [];
            if (!empty($tracking)) {
                $where[] = ['tracking', 'like', $tracking . '%'];
            }

            $order = new orderModel();
            $list = $order->getOrders($where);

            for ($i = 0; $i < count($list); ++$i) {
                $order_id = $list[$i]['order_id'];
                $order = new orderModel();
                $list[$i]['account'] = $order->getUserAccountByOrderId($order_id);
                $list[$i]['product_name'] = $order->getProductNameByOrderId($order_id);
            }

            return json(['code' => 0, 'msg' => 'ok', 'count' => count($list), 'data' => $list]);
        }

        return $this->fetch();
    }

    // 添加产品
    public function addOrder()
    {
        if(request()->isPost()) {

            $param = input('post.');

            $validate = new OrderValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }

            $order = new orderModel();
            $res = $order->addOrder($param);

            Log::write("添加订单：" . $param['user_id']);

            return json($res);
        }

        return $this->fetch('add');
    }

    // 编辑订单
    public function editOrder()
    {
        if(request()->isPost()) {

            $param = input('post.');

            $validate = new OrderValidate();
            if(!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }

            $order = new orderModel();
            $res = $order->editOrder($param);

            Log::write("编辑订单：" . $param['tracking']);

            return json($res);
        }

        $orderId = input('param.order_id');
        $order = new orderModel();

        $this->assign([
            'order' => $order->getOrderById($orderId)['data'],
        ]);

        return $this->fetch('edit');
    }

    /**
     * 删除订单
     * @return \think\response\Json
     */
    public function delOrder()
    {
        if(request()->isAjax()) {

            $orderId = input('param.id');

            $order = new orderModel();
            $res = $order->delOrder($orderId);

            Log::write("删除订单：" . $orderId);

            return json($res);
        }
    }

    public function freightDetail($orderId) {
        try {
            $order = new orderModel();
            $orderRes = $order->getOrderById($orderId);
            $userId = $orderRes['data']['user_id'];
            $freight = $orderRes['data']['freight'];
            $tracking = $orderRes['data']['tracking'];
            $status = $orderRes['data']['status'];
            $user = new userModel();
            $userRes = $user->getUserById($userId);

            $this->assign([
                'province' => $userRes['data']['province'],
                'city' => $userRes['data']['city'],
                'county' => $userRes['data']['county'],
                'detail_address' => $userRes['data']['detail_address'],
                'freight' => $freight,
                'tracking' => $tracking,
                'status' => $status
            ]);

            return $this->fetch('freight');
        } catch (\Exception $e) {
            return modelReMsg(-1, [], "查询失败，没有订单信息");
        }
    }

    public function comment($orderId) {
        $order = new orderModel();
        $orderRes = $order->getOrderById($orderId);
        $userId = $orderRes['data']['user_id'];
        $productId = $orderRes['data']['product_id'];
        $user = new userModel();
        $userRes = $user->getUserById($userId);
        $userName = $userRes['data']['account'];
        $product = new productModel();
        $productRes = $product->getProductById($productId);
        $productName = $productRes['data']['product_name'];
        $comment = new commentModel();
        $commentRes = $comment->getCommentByOrderId($orderId);
        $content = $commentRes['data']['content'];
        $imgUrl = $commentRes['data']['imgUrl'];

        $this->assign([
           'userName' => $userName,
           'productName' => $productName,
            'content' => $content,
            'imgUrl' => $imgUrl
        ]);

        return $this->fetch('comment');
    }
}