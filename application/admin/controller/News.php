<?php
namespace app\admin\controller;
use app\admin\model\News as newsModel;
use app\admin\validate\NewsValidate;
use tool\Log;
class News extends Base
{
    // 新闻列表
    public function index()
    {
        if(request()->isAjax()) {
            $title = input('param.title');
            $where = [];
            if (!empty($title)) {
                $where[] = ['title', 'like', '%' . $title . '%'];
            }
            $news = new newsModel();
            $res = $news->getNews($where);

            return json(['code' => 0, 'msg' => 'ok', 'count' => count($res), 'data' => $res]);
        }
        return $this->fetch();
    }
    // 添加新闻
    public function addNews() {
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new NewsValidate();
            if(!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $news = new newsModel();
            $res = $news->addNews($param);
            Log::write("添加新闻：" . $param['title']);
            return json($res);
        }
        return $this->fetch('add');
    }
    // 编辑新闻
    public function editNews()
    {
        if(request()->isPost()) {
            $param = input('post.');
            $validate = new NewsValidate();
            if(!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $news = new newsModel();
            $res = $news->editNews($param);
            Log::write("编辑新闻：" . $param['title']);
            return json($res);
        }
        $newsId = input('param.news_id');
        $this->assign([
            'news' => (new \app\admin\model\News())->getNewsById($newsId)['data']
        ]);
        return $this->fetch('edit');
    }
    // 删除新闻
    public function delNews()
    {
        if(request()->isAjax()) {
            $newsId = input('param.id');
            $news = new newsModel();
            $res = $news->delNews($newsId);
            Log::write("删除新闻：" . $newsId);
            return json($res);
        }
    }
}