<?php

namespace app\front\controller;

use app\api\Controller\Base;
use think\Request;

class Goods extends Base
{
    /**
     * 商品详情页
     *
     */
    public function detail(){


        return view('test');
        //$this->display('test');
    }
}
