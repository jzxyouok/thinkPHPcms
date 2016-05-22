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
        if ($_POST){
            if ( !isset($_POST['title']) || !$_POST['title']){
                return show(0,'标题不能为空' );
            }
            if ( !isset($_POST['small_title']) || !$_POST['small_title']){
                return show(0,'短标题不能为空' );
            }
            if ( !isset($_POST['content']) || !$_POST['content']){
                return show(0,'内容不能为空' );
            }
            if ( !isset($_POST['catid']) || !$_POST['catid']){
                return show(0,'文章栏目不存在' );
            }
            if ( !isset($_POST['keywords']) || !$_POST['keywords']){
                return show(0,'关键字不能为空' );
            }

            $newsId = D('News')->insert($_POST);
            if ($newsId){
                $newsContentData['content'] = $_POST['content'];
                $newsContentData['news_id'] = $newsId;
                $cId = D('NewsContent')->insert($newsContentData);
                if ($cId){
                    return show(1,'新增成功' );
                }else{
                    return show(0,'主表新增成功，副本新增失败' );
                }
            }

        }else {

            $webSiteMenu = D('Menu')->getBarMenus();
            $titleFontColor = C('TITLE_FONT_COLOR');
            $copyfrom = C('COPY_FROM');

            $this->assign('webSiteMenu', $webSiteMenu);
            $this->assign('titleFontColor', $titleFontColor);
            $this->assign('copyfrom', $copyfrom);
            $this->display();
        }
    }
}