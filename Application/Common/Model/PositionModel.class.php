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

}