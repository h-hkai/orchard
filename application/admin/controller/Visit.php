<?php
namespace app\admin\controller;
use app\admin\model\Visit as visitModel;
use app\admin\model\Project as projectModel;
use app\admin\model\User as userModel;
use app\admin\validate\VisitValidate;
use tool\Log;
class Visit extends Base
{
    // 订单列表
    public function index()
    {
        if(request()->isAjax()) {
            $visit_id = input('param.visit_id');
            $where = '';
            if (isset($visit_id))
                $where = 'visit_id='.$visit_id;
            $order = new visitModel();
            $res = $order->getOrders($where);
            $project = new projectModel();
            for ($i = 0; $i < count($res); ++$i) {
                $projectId = $res[$i]['project_id'];
                $projectRes = $project->getProjectById($projectId)['data'];
                $res[$i]['project_name'] = $projectRes['name'];
            }
            $user = new userModel();
            for ($i = 0; $i < count($res); ++$i) {
                $userId = $res[$i]['user_id'];
                $userRes = $user->getUserById($userId)['data'];
                $res[$i]['user_name'] = $userRes['account'];
            }
            return json(['code' => 0, 'msg' => 'ok', 'count' => count($res), 'data' => $res]);
        }
        return $this->fetch();
    }
    // 添加订单
    public function addOrder() {
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new VisitValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $visit = new visitModel();
            $res = $visit->addOrder($param);
            Log::write("添加订单：" . $param['project_id']);
            return json($res);
        }
        $this->assign([
            'projects' => (new \app\admin\model\Project())->getAllProjects()['data']
        ]);
        return $this->fetch('add');
    }
    // 编辑订单
    public function editOrder()
    {
        if(request()->isPost()) {
            $order = input('post.');
            $validate = new VisitValidate();
            if(!$validate->scene('edit')->check($order)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $visit = new visitModel();
            $res = $visit->editOrder($order);
            Log::write("编辑订单：" . $order['visit_id']);
            return json($res);
        }
        $visitId = input('param.visit_id');
        $this->assign([
            'projects' => (new \app\admin\model\Project())->getAllProjects()['data'],
            'order' => (new \app\admin\model\Visit())->getOrderById($visitId)['data']
        ]);
        return $this->fetch('edit');
    }
    //删除订单
    public function delOrder()
    {
        if(request()->isAjax()) {
            $orderId = input('param.id');
            $visit = new visitModel();
            $res = $visit->delOrder($orderId);
            Log::write("删除订单：" . $orderId);
            return json($res);
        }
    }
}