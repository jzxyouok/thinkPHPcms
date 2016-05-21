<?php
/**
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 20:51
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Crypt\Driver\Think;
use Think\Exception;

class MenuController extends Controller{
    public function add()
    {
        if($_POST){
            if (!isset($_POST['name']) || !$_POST['name']){
                return show(0,"菜单名不能为空");
            }
            if (!isset($_POST['m']) || !$_POST['m']){
                return show(0,"模块名不能为空");
            }
            if (!isset($_POST['c']) || !$_POST['c']){
                return show(0,"控制器名不能为空");
            }
            if (!isset($_POST['f']) || !$_POST['f']){
                return show(0,"方法名不能为空");
            }
            if($_POST['menu_id']){
                return $this->save($_POST);
            }

            $menuId = D('Menu')->insert($_POST);
            if($menuId){
                return show(1,"新增成功",$menuId);
            }
            return show(0,"新增失败",$menuId);

        }else {
            $this->display();
        }
    }

    public function edit(){
        $menuId = $_GET['id'];

        $menu = D('Menu')->find($menuId);
        $this->assign('menu',$menu);
        $this->display();
    }

    public function save($data){
        $menuId = $data['menu_id'];
        unset($data['menu_id']);
        try {
            $id = D('Menu')->updateMenuById($menuId, $data);
            if ($id === false){
                return show(0, "编辑失败");
            }
            return show(1,"更新成功" );
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
    }
    public function setStatus(){
        if ($_POST){
            $id = $_POST['id'];
            $status = $_POST['status'];
            try {
                $res = D('Menu')->updateStatusById($id, $status);
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

    public function listorder(){
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        if ($listorder){
            try{
                foreach ($listorder as $menu_id => $v) {
                    $id = D('Menu')->upadteMenuListorderById($menu_id, $v);
                    if ($id === false) {
                        $errors[] = $menu_id;
                    }
                }
            }catch (Exception $e){
                    return show(0,$e->getMessage(), array('jump_url'=>$jumpUrl));
            }
            if ($errors){
                return show(0,"排序错误-" .implode(',', $errors),array('jump_url'=>$jumpUrl));
            }
            return show(1,"排序成功" ,array('jump_url'=>$jumpUrl));
        }
        return show(0,"排序数据失败", array('jump_url'=>$jumpUrl));
    }

    public function index()
    {
        $data = array();

        if( isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0,1))){
            $data['type'] = intval($_REQUEST['type']);
            $this->assign('type',$data['type']);
        }else{
            $this->assign('type',-1);
        }
        /*
        *分页原理
        */
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 5;
        $menus = D('Menu')->getMenus($data,$page,$pageSize);
        $menusCount = D('Menu')->getMenusCount($data);

        /*
         * thinkPHP自带的分页类
         * */
        $res = new \Think\Page($menusCount,$pageSize);
        $pageRes = $res->show();
        $this->assign('menus',$menus);
        $this->assign('pageRes',$pageRes);
        $this->display();
    }
}