<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Think\Controller;

class ContentController extends Controller {
    
    public function index(){
        $data = array();
        $title = $_GET['title'];
        if ($title){
            $data['title'] = $title;
        }
        if ($_GET['catid']){
            $data['catid'] = intval($_GET['catid']);
        }
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 5;

        $news = D('News')->getNews($data,$page,$pageSize);
        $count = D('News')->count($data);

        $res = new \Think\Page($count,$pageSize);
        $pageres = $res->show();

        $this->assign('news',$news);
        $this->assign('pageres',$pageres);
        $this->assign('webSiteMenu',D('Menu')->getBarMenus());
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
    public function edit(){
        $newId = $_GET['id'];
        if ( $newId){
            $new = D('News')->find($newId);
            if ($new){
                $newContent = D('NewsContent')->find($newId);
                $new['content'] = $newContent['content'];
            }
        }

        $webSiteMenu = D('Menu')->getBarMenus();
        $titleFontColor = C('TITLE_FONT_COLOR');
        $copyfrom = C('COPY_FROM');

        $this->assign('webSiteMenu', $webSiteMenu);
        $this->assign('titleFontColor', $titleFontColor);
        $this->assign('copyfrom', $copyfrom);
        $this->assign('new',$new);

        $this->display();
    }
}