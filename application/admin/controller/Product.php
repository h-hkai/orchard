<?php

namespace app\admin\controller;

use app\admin\model\Product as productModel;
use app\admin\validate\ProductValidate;
use tool\Log;

class Product extends Base
{
    // 产品列表
    public function index()
    {
        if(request()->isAjax()) {

//            $limit = input('param.limit');
            $productName = input('param.product_name');

            $where = [];
            if (!empty($productName)) {
                $where[] = ['product_name', 'like', $productName . '%'];
            }

            $product = new productModel();
            $list = $product->getProducts($where);

            return json(['code' => 0, 'msg' => 'ok', 'count' => count($list), 'data' => $list]);
        }

        return $this->fetch();
    }

    // 添加产品
    public function addProduct()
    {
        if(request()->isPost()) {

            $param = input('post.');
            $param['createTime'] = date('y-m-d');

            unset($param['productImg']);

            $validate = new ProductValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }

            $product = new productModel();
            $res = $product->addProduct($param);

            Log::write("添加产品：" . $param['product_name']);

            return json($res);
        }


        return $this->fetch('add');
    }

    // 编辑产品
    public function editProduct()
    {
        if(request()->isPost()) {

            $param = input('post.');

            $validate = new ProductValidate();
            if(!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }

            $product = new productModel();
            $res = $product->editProduct($param);

            Log::write("编辑产品：" . $param['product_name']);

            return json($res);
        }

        $productId = input('param.product_id');
        $product = new productModel();

        $this->assign([
            'product' => $product->getProductById($productId)['data'],
        ]);

        return $this->fetch('edit');
    }

    /**
     * 删除产品
     * @return \think\response\Json
     */
    public function delProduct()
    {
        if(request()->isAjax()) {

            $productId = input('param.id');

            $product = new productModel();
            $res = $product->delProduct($productId);

            Log::write("删除产品：" . $productId);

            return json($res);
        }
    }

    /**
     * 图片上传
     */
    public function upload()
    {
        $file = request()->file('productImg');
        $info = $file->move('upload/img');
        $name = $info->getSaveName();
        $name = str_replace('\\', '/', $name);
        $path = '/orchard/public/upload/img/';
        $url = $path.$name;
        $elem = '<img class="layui-upload-img" src=\''. $url. '\' height="50px" weight="50px"/>';
        return json(['elem'=>$elem]);
    }
}