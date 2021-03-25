<?php
namespace app\admin\controller;
use app\admin\model\Shopping as shoppingModel;
use app\admin\validate\CardValidate;
use tool\Log;
class Shopping extends Base
{
    // 购物卡列表
    public function index()
    {
        if(request()->isAjax()) {
            $cardId = input('param.card_id');
            $where = "";
            if (!empty($cardId)) {
                $where = "card_id=".$cardId;
            }
            $card = new shoppingModel();
            $list = $card->getShopCards($where);
            return json(['code' => 0, 'msg' => 'ok', 'count' => count($list), 'data' => $list]);
        }
        return $this->fetch();
    }
    // 添加产品
    public function addCard()
    {
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new CardValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $card = new shoppingModel();
            $res = $card->addCard($param);
            Log::write( "用户".$param['user_id']." 添加购物卡");
            return json($res);
        }
        $this->assign([
            'roles' => (new \app\admin\model\Role())->getAllRoles()['data']
        ]);
        return $this->fetch('add');
    }
    // 编辑购物卡
    public function editCard()
    {
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new CardValidate();
            if(!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $card = new shoppingModel();
            $res = $card->editCard($param);
            Log::write("用户".$param['user_id']."编辑购物卡");
            return json($res);
        }
        $cardId = input('param.card_id');
        $card = new shoppingModel();
        $this->assign([
            'card' => $card->getCardById($cardId)['data']
        ]);
        return $this->fetch('edit');
    }
    //删除购物卡
    public function delCard()
    {
        if(request()->isAjax()) {
            $cardId = input('param.id');
            $card = new shoppingModel();
            $res = $card->delCard($cardId);
            Log::write("删除购物卡：" . $cardId);
            return json($res);
        }
    }
}