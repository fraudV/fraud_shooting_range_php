<?php

namespace app\controller;

use app\BaseController;
use app\controller\model\Environment;
use app\controller\model\EnvironmentModel;
use app\controller\vo\Vo;
use think\facade\Filesystem;
use think\facade\View;

class Env extends BaseController
{
    public function index($id)
    {

        $env = EnvironmentModel::where('id', $id)->find();
        $env->ports = json_decode($env->ports);

        $answer = request()->get('answer');
        if ($answer){
            return new Vo(0,$env->address);
        }
        return View::fetch('index',['env'=>$env]);
    }

    public function start($id)
    {
        $env = EnvironmentModel::where('status', 1)->find();
        if ($env!=null){
            return new Vo(1,$env->name.' 靶场启动中，请先停止');
        }

        // 启动环境
        $env = EnvironmentModel::where('id', $id)->find();

        // 创建启动脚本
        $sf = Filesystem::path('file/ssh/s.sh');
        $sshfile = fopen($sf, "w") or die("Unable to open file!");

        $ports = json_decode($env->ports,true);

        foreach ($ports as $key => $value) {
            $ports[$key]=rand(50000, 60000);
            fwrite($sshfile, 'export '.$key.'='.$ports[$key]."\n");
        }
        $flag = getFlag();
        fwrite($sshfile, 'export F_FLAG='.$flag."\n");
        $env->ports = json_encode($ports);
        $env->status = 1;
        $env->save();

        $dockerfile = Filesystem::path($env->path.'/docker-compose.yml');

        fwrite($sshfile, 'docker compose -f '.$dockerfile." up -d\n");
        fclose($sshfile);

        // 获取docker文件路
        $se = shell_exec('sudo bash -c '.$sf);
        return new Vo(1,$env->name.' 靶场启动成功',$env->name,$se);
    }

    public function stop($id){
        $env = EnvironmentModel::where('id', $id)->find();
        if ($env->status!=1){
            return new Vo(1,'靶场未启动');
        }
        $dockerfile = Filesystem::path($env->path.'/docker-compose.yml');
        $se = shell_exec('sudo docker compose -f '.$dockerfile.' down');
        $env->status =0;
        $env->save();
        return new Vo(0,$env->name.' 靶场停止成功',$se);
    }


    public function controls()
    {
        return View::fetch('controls');
    }
    public function env_json($page,$limit)
    {
        $env=EnvironmentModel::page($page,$limit)->select();
        $c = EnvironmentModel::count();
        return new Vo(0,'查询成功',$c,$env);
    }
}