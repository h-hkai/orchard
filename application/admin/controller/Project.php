<?php
namespace app\admin\controller;
use app\admin\model\Project as projectModel;
use app\admin\validate\ProjectValidate;
use tool\Log;
class Project extends Base
{
    public function index() {
        if(request()->isAjax()) {
            $project_name = input('param.project_name');
            $where = [];
            if (!empty($project_name)) {
                $where[] = ['name', 'like', '%' . $project_name . '%'];
            }
            $order = new projectModel();
            $list = $order->getProjects($where);
            return json(['code' => 0, 'msg' => 'ok', 'count' => count($list), 'data' => $list]);
        }
        return $this->fetch();
    }
    // 添加项目
    public function addProject()
    {
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new ProjectValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $project = new projectModel();
            $res = $project->addProject($param);
            Log::write("添加项目：" . $param['name']);
            return json($res);
        }
        return $this->fetch('add');
    }
    // 编辑项目
    public function editProject()
    {

        if(request()->isPost()) {
            $param = input('post.');
            $validate = new ProjectValidate();
            if(!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $project = new projectModel();
            $res = $project->editProject($param);
            Log::write("编辑产品：" . $param['name']);
            return json($res);
        }
        $project_id = input('param.project_id');
        $project = new projectModel();

        $this->assign([
            'project' => $project->getProjectById($project_id)['data'],
        ]);
        return $this->fetch('edit');
    }
    //删除项目
    public function delProject()
    {
        if(request()->isAjax()) {
            $projectId = input('param.id');
            $project = new projectModel();
            $res = $project->delProject($projectId);
            Log::write("删除产品：" . $projectId);
            return json($res);
        }
    }
}