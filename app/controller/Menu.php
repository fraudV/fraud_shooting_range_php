<?php

namespace app\controller;

use app\controller\dao\MenuNode;
use app\controller\model\EnvironmentModel;
use app\controller\model\MenuModel;
use app\controller\vo\Vo;
use think\facade\Filesystem;
use think\facade\View;
use ZipArchive;

class Menu
{
    public function index()
    {
        return View::fetch('index');
    }

    public function menu_json()
    {
        $menu_all = MenuModel::select();
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

        return new Vo(0,'查询成功',count($menu_all),$menu_nodes);
    }

    public function add($id)
    {
        return View::fetch('add',['id'=>$id]);
    }

    public function save()
    {
        $file = null;

        $f = request()->post('file');
        if($f!=null && $f!=''){
            $file = request()->file('file');
        }

        $username = request()->post('username');
        $to = request()->post('to');
        $superiors = request()->post('superiors');
        $ports= request()->post('ports');
        $address = request()->post('address');
        if ($file) {
            // 验证文件格式和大小
            try {
                validate(['file' => [
                    'fileExt'  => 'zip',
                    'fileSize' => 10485760, // 最大10MB
                ]])->check(['file' => $file]);
            } catch (\think\exception\ValidateException $e) {
                return new Vo(1, $file->getError());
            }


            // 获取文件路径
            $info = Filesystem::putFile('uploads', $file);
            if (!$info) {
                return new Vo(1,  '文件上传失败');
            }

            // 获取文件路径
            $filePath = Filesystem::path($info);
            $path = 'file/docker/environment/'.time();
            // 解压文件
            $zip = new ZipArchive();
            if ($zip->open($filePath) === TRUE) {


                $extractPath =  Filesystem::path($path);
                $zip->extractTo($extractPath);
                $zip->close();
            }else{
                return new Vo(1,'无法解压');
            }
        }


        if ($file){
            $env = EnvironmentModel::create([
                'name' => $username,
                'path' => $path,
                'ports'=>$ports,
                'address'=>$address
            ]);
        }
        MenuModel::create([
            'name'  =>  $username,
            'to' =>  $to,
            'superiors'=>$superiors,
            'env_id'=>(isset($env) && $env!=null?$env->id:null),
        ]);




        return new Vo(0,'添加成功,即将刷新当前页面');
    }

    public function del($id,$del)
    {

        $menu = MenuModel::where('id', $id)->find();
        if($menu==null){
            return new Vo(1,'当前菜单不存在');
        }

        if ($del){
            $env = EnvironmentModel::where('id',$menu->env_id)->find();
            if ($env!=null){
                $dockerfile = Filesystem::path($env->path);
                deleteDirectory($dockerfile);
                $menu->delete();
                $env->delete();
            }else{
                $menu->delete();
            }
        }else{
            $menu->delete();
        }
        return new Vo(0,'删除成功');

    }

}