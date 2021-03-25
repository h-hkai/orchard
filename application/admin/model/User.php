<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class User extends Model
{
    protected $table = 'bsa_user';

    /**
     * 获取用户
     * @param $where
     * @return array
     */
    public function getUsers($where)
    {

        try {

            $res = Db::name('user')->where($where)->select();

        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return $res;
    }


    /**
     * 增加用户
     * @param $user
     * @return array
     */
    public function addUser($user)
    {
        try {

            $has = $this->where('account', $user['account'])->findOrEmpty()->toArray();
            if (!empty($has)) {
                return modelReMsg(-2, '', '该用户名已存在');
            }

            $this->insert($user);
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加用户成功');
    }

    /**
     * 获取用户信息
     * @param $userId
     * @return array
     */
    public function getUserById($userId)
    {
        try {

            $info = $this->where('user_id', $userId)->findOrEmpty()->toArray();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

    /**
     * 编辑用户信息
     * @param $user
     * @return array
     */
    public function editUser($user)
    {
        try {

            $has = $this->where('account', $user['account'])->where('account', '<>', $user['account'])
                ->findOrEmpty()->toArray();
            if (!empty($has)) {
                return modelReMsg(-2, '', '给用户已拥有购物卡');
            }

            $this->save($user, ['user_id' => $user['user_id']]);
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑产品成功');
    }

    /**
     * 删除用户
     * @param $userId
     * @return array
     */
    public function delUser($userId)
    {
        try {
            $this->where('user_id', $userId)->delete();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '删除成功');
    }
}
