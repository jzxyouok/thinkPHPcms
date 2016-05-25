<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 14:39
 */
namespace Common\Model;
use Think\Model;

class PositionContentModel extends Model{
    private $_db;
    public function __construct()
    {
        $this->_db = M('position_content');
    }
    public function insert($data){
        $data['create_time'] = time();
        return $this->_db->add($data);
    }
    public function select($data=array(),$limit=0){
        if ($data['title']){
            $data['title'] = array('like','%'.$data['title'].'%');
        }
        $this->_db->where($data)->order('listorder desc,id desc');
        if ($limit){
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();
        return $list;
    }
    public function updateStatusById($id,$status){
        if ( !$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if (!is_numeric($status)){
            throw_exception("状态不合法");
        }
        $data['status'] = $status;
        return $this->_db->where('id='.$id)->save($data);
    }
}