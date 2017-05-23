<?php

namespace app\api\controller;

//use think\Controller;
use app\api\controller\Base;
use think\Request;
use app\api\logic\Goods as GoodsLogic;
class Goods extends Base
{
    /**
     * 商品详情
     * @param int $goods_id 
     * @return \think\Response
     */
    public function goodsDetail(){
        $goodsId = Request::instance()->param('id');
        $goodsId = intval($goodsId);
        if($goodsId <= 0){
            return json(['code'=>0, 'message'=>'参数错误！']);
        }
        $storeId = STOREID;
        $logic = new GoodsLogic;

        $data = $logic->getById($storeId, $goodsId);

        if(empty($data)){
            return ['code'=>0,'message'=>'参数错误'];
        }

        //商品详情，包括文本
        $field = 'author,publisher,publish_time as publishtime,img,imgs,summary,catalog,author_intro,description';
        $res = $logic->getGoodsDetail($storeId, $goodsId, $field);

        $data['detail'] = $res;

        return ['code'=>1,'message'=>'ok','data'=>$data];
    }

    /**
     * 提交订单前检查购物车
     * @param $goods
     * @return \think\Response
     */
    public function checkGoods(){

        //$goods = Request::instance()->param();
        $goods = [['goods_id' => 1, 'num' => 2],['goods_id' => 2, 'num' => 3]];
        $storeId = STOREID;
        $logic = new GoodsLogic;
        $goodsId = [];
        foreach ($goods as $v){
            array_push($goodsId, $v['goods_id']);
        }

        $data = $logic->getById($storeId, $goodsId);

        //判断库存
        $code = 1;
        foreach ($goods as $value){
            foreach ($data as &$v){
                if($value['goods_id'] == $v['id']){
                    if($value['num'] > $v['goods_amount']){
                        $code = 0;
                        $v['goods_lack'] = 1;
                    }
                }
            }
        }
        if($code == 1){
            $message = 'ok';
        }else{
            $message = '库存不足';
        }
        return ['code'=>$code, 'message'=>$message,'data'=>$data];
    }

    /**
     * 查看全部商品列表
     * @param
     * @return \think\Response
     */
}
