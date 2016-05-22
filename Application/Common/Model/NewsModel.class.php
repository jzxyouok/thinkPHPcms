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
}