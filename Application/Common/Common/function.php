<?php
/**
 * 够公用的方法
 * Created by PhpStorm.
 * User: guojingfeng
 * Date: 2016/5/19
 * Time: 12:05
 */

function show($status,$message,$data=array()){
    $result = array(
        'status'=>$status,
        'message'=>$message,
        'data'=>$data
    );
    exit(json_encode($result));
}
 function getMd5Password($password){
     return md5($password.C('MD5_PRE'));
 }
function getMenuType($type){
    return $type == 1 ? "后台菜单":"前端导航";
}
function status($status){
    if($status == 1){
        $str = "正常";
    }elseif ($status == 0){
        $str = "关闭";
    }elseif ($status == -1){
        $str = "删除";
    }
    return $str;
}
function getAdminMenuUrl($nav){
    $url = '/admin.php?c='.$nav['c'].'&a='.$nav['a'];
    if ( $nav['f'] == 'index'){
        $url = '/admin.php?c='.$nav['c'];
    }
    return $url;
}
function getActive($nav){
    $c = strtolower(CONTROLLER_NAME);
    if ( strtolower($nav) == $c){
        return 'class="active"';
    }
    return '';
}