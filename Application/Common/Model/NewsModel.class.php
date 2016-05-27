<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 14:39
 */
namespace Common\Model;
use Think\Model;

class NewsModel extends Model{
    private $_db;
    public function __construct()
    {
        $this->_db = M('news');
    }

    public function insert( $data = array() ){
        if ( !$data || !is_array($data)){
            return 0;
        }
        $data['create_time'] = time();
        $data['username'] = getLoginUsername();
        return $this->_db->add($data);
    }
    public function getNews($data,$page,$pageSize=10){
        $data['status'] = array('neq',-1);
        $conditinos =$data;
        if (isset($data['title']) && $data['title']){
            $conditinos['title'] = array('like','%'.$data['title'].'%');
        }
        if (isset($data['catid']) && $data['catid']){
            $conditinos['catid'] = intval($data['catid']);
        }

        $offset = ($page-1) * $pageSize;
        $list = $this->_db->where($conditinos)->order('listorder desc,news_id desc')->limit($offset,$pageSize)->select();
        return $list;
    }
    public function count($data){
        $data['status'] = array('neq',-1);
        $conditinos =$data;
        if (isset($data['title']) && $data['title']){
            $conditinos['title'] = array('like','%'.$data['title'].'%');
        }
        if (isset($data['catid']) && $data['catid']){
            $conditinos['catid'] = intval($data['catid']);
        }
        return $this->_db->where($conditinos)->count();
        
    }
    public function find($id){
        return $this->_db->where('news_id='.$id)->find();
    }
    public function updateById($id,$data){
        if ( !$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if ( !$data || !is_array($data)){
            throw_exception('数据不合法');
        }
        return $this->_db->where('news_id='.$id)->save($data);
    }
    public function updateStatusById($id,$status){
        if ( !is_numeric($status)){
            throw_exception('status不能为非数字');
        }
        if ( !$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        $data['status'] = $status;
        return $this->_db->where('news_id='.$id)->save($data);
    }
    public function upadteNewsListorderById($id,$data){
        if ( !$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        $list['listorder'] = $data;
        return $this->_db->where('news_id='.$id)->save($list);
    }
    public function getNewsByNewsIdIn($newsId){
        if (!is_array($newsId)){
            throw_exception('参数不合法');
        }
        $data = array(
            'news_id' => array('in',implode(',', $newsId)),
        );
        return $this->_db->where($data)->select();

    }
    
    /**
     * 获取排行的数据
     * @param array $data
     * @param int $limit
     * @return array
     */
    public function getRank($data = array(), $limit = 30) {
        $list = $this->_db->where($data)->order('count desc,news_id desc ')->limit($limit)->select();
        return $list;
    }
    public function select($data = array(), $limit = 100) {
        $conditions = $data;
        $list = $this->_db->where($conditions)->order('news_id desc')->limit($limit)->select();
        return $list;
    }
    /*
     * 更新阅读计数
     */
    public function updateCount($id, $count) {
        if(!$id || !is_numeric($id)) {
            throw_exception("ID 不合法");

        }
        if(!is_numeric($count)) {
            throw_exception("count不能为非数字");
        }

        $data['count'] = $count;
        return $this->_db->where('news_id='.$id)->save($data);

    }
}