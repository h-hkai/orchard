<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Shopping extends Model
{
    protected $table = 'bsa_shop_card';

    /**
     * 获取购物卡
     * @param $where
     * @return array
     */
    public function getShopCards($where)
    {

        try {

            $res = Db::name('shop_card')->where($where)->select();

        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return $res;
    }


    /**
     * 增加产品
     * @param $card
     * @return array
     */
    public function addCard($card)
    {
        try {

            $has = $this->where('user_id', $card['user_id'])->findOrEmpty()->toArray();
            if(!empty($has)) {
                return modelReMsg(-2, '', '该用户已拥有购物卡');
            }

            $this->insert($card);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加购物卡成功');
    }

    /**
     * 获取产品信息
     * @param $cardId
     * @return array
     */
    public function getCardById($cardId)
    {
        try {

            $info = $this->where('card_id', $cardId)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

    /**
     * 编辑购物卡
     * @param $card
     * @return array
     */
    public function editCard($card)
    {
        try {

            $has = $this->where('user_id', $card['user_id'])->where('user_id', '<>', $card['user_id'])
                ->findOrEmpty()->toArray();
            if(!empty($has)) {
                return modelReMsg(-2, '', '给用户已拥有购物卡');
            }

            $this->save($card, ['card_id' => $card['card_id']]);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑产品成功');
    }

    /**
     * 删除购物卡
     * @param $cardId
     * @return array
     */
    public function delCard($cardId)
    {
        try {
            $this->where('card_id', $cardId)->delete();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '删除成功');
    }
}