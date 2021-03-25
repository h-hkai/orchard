<?php
namespace app\admin\controller;
use app\admin\model\User as userModel;
use app\admin\validate\UserValidate;
use tool\Log;
class User extends Base
{
    // 用户列表
    public function index()
    {
        if(request()->isAjax()) {
            $account = input('param.account');
            $where = [];
            if (!empty($account)) {
                $where[] = ['account', 'like', $account . '%'];
            }
            $user = new userModel();
            $list = $user->getUsers($where);
            for ($i = 0; $i < count($list); ++$i) {
                $list[$i]['address'] = $list[$i]['province'].$list[$i]['city'].' '.$list[$i]['detail_address'];
            }
            return json(['code' => 0, 'msg' => 'ok', 'count' => count($list), 'data' => $list]);
        }
        return $this->fetch();
    }
    // 添加用户
    public function addUser()
    {
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new UserValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $param['passwd'] = makePassword($param['passwd']);
            $user = new userModel();
            $res = $user->addUser($param);
            Log::write( "添加用户： ".$param['account']);
            return json($res);
        }
        return $this->fetch('add');
    }
    // 编辑用户信息
    public function editUser()
    {
        if(request()->isPost()) {
            $param = input('post.');
            if (!isset($param['passwd'])) {
                $param['passwd'] = $param['oldPasswd'];
            } else {
                $param['passwd'] = makePassword($param['passwd']);
            }
            $validate = new UserValidate();
            if(!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $user = new userModel();
            $res = $user->editUser($param);
            Log::write("编辑用户信息： ".$param['user_id']);
            return json($res);
        }
        $userId = input('param.user_id');
        $user = new userModel();
        $this->assign([
            'user' => $user->getUserById($userId)['data']
        ]);
        return $this->fetch('edit');
    }
    //删除用户
    public function delUser()
    {
        if(request()->isAjax()) {
            $userId = input('param.id');
            $user = new userModel();
            $res = $user->delUser($userId);
            Log::write("删除用户：" . $userId);
            return json($res);
        }
    }
}