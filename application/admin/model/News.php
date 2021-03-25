<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class News extends Model
{
    protected $table = 'bsa_news';

    /**
     * 获取新闻
     * @param where
     * @return array
     */
    public function getNews($where)
    {

        try {

            $res = Db::name('news')->where($where)->select();

        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return $res;
    }

    /**
     * 增加新闻
     * @param $news
     * @return array
     */
    public function addNews($news)
    {
        try {

            $this->insert($news);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加新闻成功');
    }

    /**
     * 编辑新闻
     * @param $news
     * @return array
     */
    public function editNews($news)
    {
        try {

            $this->save($news, ['news_id' => $news['news_id']]);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑新闻成功');
    }

    /**
     * 通过id获取新闻
     * @param $visitId
     * @return array
     */
    public function getNewsById($newsId)
    {
        try {

            $res = $this->where('news_id', $newsId)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $res, '编辑新闻成功');
    }

    /**
     * 删除新闻
     */
    public function delNews($newsId) {
        try {
            $this->where('news_id', $newsId)->delete();
        } catch (\Exception $e) {
            return modelReMsg(-1, '', $e->getMessage());
        }
        return modelReMsg(0, '', '删除成功');
    }


}