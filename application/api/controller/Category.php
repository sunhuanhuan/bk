<?php

namespace app\api\controller;

use app\api\Controller\Base;
use think\Request;
use app\api\logic\Category as CategoryLogic;
class Category extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this->Category = new CategoryLogic;
    }

    /**
     * 获取分类
     *
     * @return \think\Response
     */
    public function getCategory(){
        $data = $this->Category->getCategory();

        dump($data);exit;
        return ['code'=>1,'message'=>'ok','data'=>$data];
    }
}
