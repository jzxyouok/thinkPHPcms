<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 20:51
 */
namespace Admin\Controller;
use Think\Controller;

class PositioncontentController extends Controller{
    public function add()
    {
        $this->display();
    }

    public function index()
    {
        $positions = D('Position')->getPosition();
        //获取推荐位里面的内容
        $data['status'] = array('neq',-1);
        if ($_GET['title']){
            $data['title'] = trim($_GET['title']);
            $this->assign('title',$data['title']);
        }
        $data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $positions[0]['id'];
        $contents = D('PositionContent')->select($data);
        $this->assign('positions',$positions);
        $this->assign('positionId',$data['position_id']);
        $this->assign('contents',$contents);
        $this->display();
    }
    public function setStatus(){
        if ($_POST){
            $id = $_POST['id'];
            $status = $_POST['status'];
            try {
                $res = D('PositionContent')->updateStatusById($id, $status);
                if ($res){
                    return show(1,"操作成功" );
                }else{
                    return show(0,"操作失败" );
                }
            }catch (Exception $e){
                return show(0,$e->getMessage() );
            }
            return show(0,"没有提交的数据" );
        }
    }
}