<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 20:51
 */
namespace Admin\Controller;
use Think\Controller;

class PositionController extends CommonController{
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
    public function setStatus()
    {
        if ($_POST){
            $data['id'] = $_POST['id'];
            $data['status'] = $_POST['status'];
            parent::setStatus($data,Position );
        }
        return show(0,'没有提交的数据' );
    }
}