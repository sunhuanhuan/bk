<?php

namespace app\api\controller;

use app\api\controller\Base;
use think\Request;
use app\api\logic\Goods;
class Buy extends Base
{
    /**
     * 订单页
     * @param int $goods_id
     * @param int $num
     * @return \think\Response
     */
    public function order(){
//        $goods = Request::instance()->param();
//        $goods = json_encode($goods);
        $goods = [['goods_id' => 1, 'num' => 2],['goods_id' => 2, 'num' => 3]];
        $storeId = STOREID;
        $goodsId = [];
        foreach ($goods as $v){
            array_push($goodsId, $v['goods_id']);
        }

        $data = (new Goods)->getById($storeId, $goodsId);

        //判断库存


        dump($data);
    }
}
