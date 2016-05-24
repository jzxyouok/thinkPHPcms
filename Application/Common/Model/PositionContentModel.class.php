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
        return $this->_db->add($data);
    }

}