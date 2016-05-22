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
        $webSiteMenu = D('Menu')->getBarMenus();
        $titleFontColor = C('TITLE_FONT_COLOR');
        $copyfrom = C('COPY_FROM');

        $this->assign('webSiteMenu',$webSiteMenu);
        $this->assign('titleFontColor',$titleFontColor);
        $this->assign('copyfrom',$copyfrom);
    	$this->display();
    }
}