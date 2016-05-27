<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 21:29
 */
namespace Common\Model;
use Think\Model;

class MenuModel extends Model{
    private $_db = '';
    public function __construct()
    {
        $this->_db = M('menu');
    }
    public function insert($data=array()){
        if(!$data || !is_array($data)){
            return 0;
        }
        return $this->_db->add($data);
    }
    public function getMenus($data,$page,$pageSize){
        $data['status']= array('neq',-1);
        $offset = ($page-1) * $pageSize;
        $list = $this->_db->where($data)->order('listorder desc,menu_id desc')->limit($offset,$pageSize)->select();
        return $list;
    }
    public function getMenusCount($data){
        $data['status']= array('neq',-1);
        return $this->_db->where($data)->count();
    }
    public function find($id){
        if( !$id || !is_numeric($id)){
            return array();
        }
        return $this->_db->where('menu_id='.$id)->find();
    }
    public function updateMenuById($id,$data){
        if ( !$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        
        if ( !$data || !is_array($data)){
            throw_exception("数据不合法");
        }
        
        return $this->_db->where('menu_id='.$id)->save($data);
    }
    public function updateStatusById($id,$status){
        if ( !$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if ( !$status || !is_numeric($status)){
            throw_exception("状态不合法");
        }
        $data['status'] = $status;
        return $this->_db->where('menu_id='.$id)->save($data);
    }
    public function upadteMenuListorderById($id,$listorder){
        if ( !$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        $data = array(
            'listorder'=>intval($listorder)
        );
        return $this->_db->where('menu_id='.$id)->save($data);
    }
    public function getAdminMenu(){
        $data = array(
          'status'=> array('neq',-1),
          'type'=> 1,
        );
        return $this->_db->where($data)->order('listorder desc,menu_id desc')->select();
    }
    public  function getBarMenus(){
        $data=array(
            'status'=>1,
            'type'=>0,
        );
        $res = $this->_db->where($data)->order('listorder desc,menu_id desc')->select();
        return $res;
    }
}
