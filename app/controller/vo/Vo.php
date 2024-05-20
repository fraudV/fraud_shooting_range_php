<?php

namespace app\controller\vo;

class Vo
{
    public $code; //状态码
    public $msg; //信息
    public $count;
    public $data; //响应数据

    function __construct( $code,$msg,$count=0,$data= null){
        $this->code=$code;
        $this->msg = $msg;
        $this->count = $count;
        $this->data=$data;
    }

    public function toJson() {
        return json_encode([
            'code' => $this->code,
            'msg' => $this->msg,
            'data' => $this->data,
        ]);
    }

}