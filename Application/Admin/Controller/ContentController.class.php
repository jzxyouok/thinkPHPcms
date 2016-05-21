<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Think\Controller;
class ContentController extends Controller {
    
    public function index(){
    	$this->display();
    }

    public function add() {
    	$this->display();
    }
}