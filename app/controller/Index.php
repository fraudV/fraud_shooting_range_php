<?php
namespace app\controller;

use app\BaseController;
use app\controller\dao\MenuNode;
use app\controller\model\Menu;
use app\controller\model\MenuModel;
use think\facade\View;

class Index extends BaseController
{

    /**
     * 加载首页及目录内容
     * @return string
     */
    public function index(): string
    {
        $menu_all = MenuModel::where('del',0)->select();
        $menu_nodes = [];
        foreach ($menu_all as $menu){
            if ($menu->superiors==0){
                array_push($menu_nodes,new MenuNode($menu));
                continue;
            }
            foreach ($menu_nodes as $ma){
                if($ma->get_tree($menu)){
                    break;
                }

            }

        }

        return View::fetch('/index',['menu_nodes'=>$menu_nodes,'demo_time'=>time()]);
    }




}
