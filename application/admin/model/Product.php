<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Product extends Model
{
    /**
     * 获取产品
     * @return array
     */
    public function getProducts($where)
    {

        try {

            $res = Db::name('product')->where($where)->select();

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
    public function addProduct($product)
    {
        try {

            $has = $this->where('product_name', $product['product_name'])->findOrEmpty()->toArray();
            if(!empty($has)) {
                return modelReMsg(-2, '', '产品名已经存在');
            }

            $this->insert($product);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加产品成功');
    }

    /**
     * 获取产品信息
     * @param $productId
     * @return array
     */
    public function getProductById($productId)
    {
        try {

            $info = $this->where('product_id', $productId)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

    /**
     * 编辑产品
     * @param $product
     * @return array
     */
    public function editProduct($product)
    {
        try {

            $has = $this->where('product_name', $product['product_name'])->where('product_id', '<>', $product['product_id'])
                ->findOrEmpty()->toArray();
            if(!empty($has)) {
                return modelReMsg(-2, '', '产品名已经存在');
            }

            $this->save($product, ['product_id' => $product['product_id']]);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑产品成功');
    }

    /**
     * 删除产品
     * @param $productId
     * @return array
     */
    public function delProduct($productId)
    {
        try {
            $this->where('product_id', $productId)->delete();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '删除成功');
    }
}