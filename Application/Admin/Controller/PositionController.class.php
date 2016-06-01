<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 20:51
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositionController extends CommonController{
    public function add()
    {
        if ($_POST){
            if (!$_POST['name']){
                return show(0,'推荐位名称不能为空' );
            }
            if (!$_POST['description']){
                return show(0,'推荐位描述不能为空' );
            }
            if ($_POST['id']){
                $this->save($_POST);
            }
            try {
                $pid = D('Position')->addPosition($_POST);
                if (!$pid) {
                    return show(0, '添加失败');
                }
            }catch (Exception $e){
                return show(0,$e->getMessage() );
            }
            return show(1,'添加成功' );
        }
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
    public function edit(){
        $id = intval($_GET['id']);
        try {
            $result = D('Position')->find($id);
            if ($result === false) {
                return show(0, '获取数据失败');
            }
        }catch (Exception $e){
            return show(0,$e->getMessage() );
        }
        $this->assign('result',$result);
        $this->display();
    }
    public function save($data){
        $id = $data['id'];
        unset($data['id']);
        try{
            $result = D('Position')->updatePositionById($id,$data);
            if ($result === false){
                return show(0,'更新失败' );
            }
        }catch (Exception $e){
            return show(0,$e->getMessage() );
        }
        return show(1,'更新成功' );
    }
}