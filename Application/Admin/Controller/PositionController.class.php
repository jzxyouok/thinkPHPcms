<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 20:51
 */
namespace Admin\Controller;
use Think\Controller;

class PositionController extends Controller{
    public function add()
    {
        $this->display();
    }

    public function index()
    {
        $result = D('Position')->getPosition();
        if ($result === false){
            return show(0,'获取数据失败' );
        }

        $this->assign('res',$result);
        $this->display();
    }
}