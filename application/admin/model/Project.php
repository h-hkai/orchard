<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Project extends Model
{
    protected $table = 'bsa_visit_project_form';

    /**
     * 获取项目
     * @return array
     */
    public function getProjects($where) {
        try {

            $res = Db::name('visit_project_form')->where($where)->select();

        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return $res;
    }

    /**
     * 增加项目
     * @param $project
     * @return array
     */
    public function addProject($project)
    {
        try {

            $this->insert($project);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加项目成功');
    }

    /**
     * 获取产品信息
     * @param $projectId
     * @return array
     */
    public function getProjectById($projectId)
    {
        try {

            $info = $this->where('project_id', $projectId)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

    /**
     * 编辑项目
     * @param $project
     * @return array
     */
    public function editProject($project)
    {
        try {

            $this->save($project, ['project_id' => $project['project_id']]);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑项目成功');
    }

    /**
     * 删除项目
     * @param $projectId
     * @return array
     */
    public function delProject($projectId)
    {
        try {
            $this->where('project_id', $projectId)->delete();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '删除成功');
    }
    /**
     * 获取所有项目的名称
     * @return array
     */
    public function getAllProjects() {
        try {
            $res = Db::name('visit_project_form')->select();
        } catch (\Exception $e) {
            return modelReMsg(-1, '', $e->getMessage());
        }
        return modelReMsg(0, $res, 'ok');
    }
}