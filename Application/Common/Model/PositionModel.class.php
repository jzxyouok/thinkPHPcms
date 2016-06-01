<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 14:39
 */
namespace Common\Model;
use Think\Model;

class PositionModel extends Model{
    private $_db;
    public function __construct()
    {
        $this->_db = M('position');
    }
    public function getPosition(){
        $data['status'] = array('eq',1);
        return $this->_db->where($data)->order('id')->select();
    }

    public function getCount($data=array()) {
        $conditions = $data;
        $list = $this->_db->where($conditions)->count();

        return $list;
    }
    public function updateStatusById($id, $status){
        if(!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        if(!is_numeric($status)) {
            throw_exception('状态不合法');
        }
        $data['status'] = $status;
        return $this->_db->where('id='.$id)->save($data);
    }
}