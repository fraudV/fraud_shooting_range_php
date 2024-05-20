<?php

namespace app\controller\dao;

class MenuNode
{
    public  $id;

    public $name;

    public $to;

    public $superiors;

    public $envId;

    public $menus;

    function __construct( $menu){
        $this->id=$menu->id;
        $this->name=$menu->name;
        $this->to=$menu->to;
        $this->superiors = $menu->superiors;
        $this->envId = $menu->env_id;
        $this->menus = [];
    }
    public function get_tree($menu){

        if($this->id==$menu->superiors){
            array_push($this->menus,new MenuNode($menu));
            return true;
        }
        foreach ($this->menus as $tm){
            if($tm->get_tree($menu)){
                return true;
            }
        }

        return false;
    }
}