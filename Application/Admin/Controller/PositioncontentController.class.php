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
        if ($_POST) {
            if(!isset($_POST['position_id']) || !$_POST['position_id']) {
                return show(0, '推荐位ID不能为空');
            }
            if(!isset($_POST['title']) || !$_POST['title']) {
                return show(0, '推荐位标题不能为空');
            }
            if(!$_POST['url'] && !$_POST['news_id']) {
                return show(0, 'url和news_id不能同时为空');
            }
            if(!isset($_POST['thumb']) || !$_POST['thumb']) {
                if($_POST['news_id']) {
                    $res = D("News")->find($_POST['news_id']);
                    if($res && is_array($res)) {
                        $_POST['thumb'] = $res['thumb'];
                    }
                }else{
                    return show(0,'图片不能为空');
                }

            }
            if($_POST['id']) {
                return $this->save($_POST);
            }
            try{
                $id = D("PositionContent")->insert($_POST);
                if($id) {
                    return show(1, '新增成功');
                }
                return show(0, '新增失败');
            }catch(Exception $e) {
                return show(0, $e->getMessage());
            }
        } else {
            $positions = D('Position')->getPosition();
            $this->assign('positions', $positions);
            $this->display();
    }
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
    public function edit() {

        $id = $_GET['id'];
        $position = D("PositionContent")->find($id);
        $positions = D("Position")->getPosition();
        $this->assign('positions', $positions);
        $this->assign('vo', $position);
        $this->display();
    }
    public function updateById($id, $data) {

        if(!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)) {
            throw_exception('更新的数据不合法');
        }
        return  $this->_db->where('id='.$id)->save($data); 
    }
    public function save($data) {
        $id = $data['id'];
        unset($data['id']);

        try {
            $resId = D("PositionContent")->updateById($id, $data);
            if($resId === false) {
                return show(0, '更新失败');
            }
            return show(1, '更新成功');
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }
    }
}