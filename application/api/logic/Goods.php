<?php
/**
 * Created by PhpStorm.
 * User: shihuan
 * Date: 2017/5/12
 * Time: 20:52
 */

namespace app\api\logic;
use app\api\model\Goods as GoodsModel;
use app\api\model\StoreGoods;
use think\Db;
use think\Cache;
class Goods
{	
	/**
     * 商品详情(不包含文本)
     * @param arr $goodsId
     * @param int or arr $storeId
     * @return arr
     */
	public function getById($storeId, $goodsId){
		if(empty($goodsId)){
            return 0;
        }

		//查看该店铺下是否有该商品
		$StoreGoods = new StoreGoods;
		$map['store_id'] = $storeId;
		$map['id'] = ['in', $goodsId];
		//$map['id'] = $goodsId;
        //限制最大长度
		$data = $StoreGoods->where($map)->limit(100)->select();
		//$goodsBase = $StoreGoods->where($map)->limit(100)->select();

//		//没有
//		if(empty($goodsBase)){
//			return 0;
//		}
//
//        unset($map);
//		if($goodsBase['is_defined'] == 0){//云商品
//
//            $con = [];
//            foreach ($goodsBase as $v){
//                array_push($con, $v['isbn']);
//            }
//            $map['isbn'] = array('in', $con);
//			$goodsDetail = Db::name('yun_goods')->where($map)->select();
//		}else{//自定义
//
//            $con = [];
//            foreach ($goodsBase as $v){
//                array_push($con, $v['id']);
//            }
//            $map['id'] = array('in', $con);
//			$goodsDetail = Db::name('defined_goods')->where($map)->find();
//		}
//
//        $data = [];
//		for($i = 0; $i < count($goodsBase); $i++){
//		    $res = $this->goodsData($storeId, $goodsBase, $goodsDetail);
//		    $data[$i] = $res;
//        }

		return $data;
	}

    /**
     * 商品详情
     * @param int $storeId
     * @param int $goodsId
     * @param str $field
     * @return arr
     */
    public function getGoodsDetail($storeId,$goodsId,$field = '*'){
        if(empty($goodsId)){
            return 0;
        }

        //查看该店铺下是否有该商品
        $StoreGoods = new StoreGoods;
        $map['store_id'] = $storeId;

        $map['id'] = $goodsId;
        //限制最大长度
        $data = DB::name('store_goods_detail')->field($field)->where($map)->find();

        return $data;
    }

    /**
     * 整合商品信息
     * @param arr $goodsBase
     * @param arr $goodsDetail
     * @param arr $storeId
     * @return arr
     */
    public function goodsData($storeId, $goodsBase, $goodsDetail){
        if(empty($goodsBase) || empty($goodsDetail)){
            return false;
        }

        //价格设定
        switch ($goodsBase['price_type']) {
            case '0':
                $store = unserialize(Cache::get('store'.$storeId));

                $truePrice = bcmul($store['default_discount'], $goodsDetail['price'], 0) / 100;
                break;
            case '1':
                $truePrice = bcmul($goodsBase['special_discount'], $goodsDetail['price'], 0) / 100;
                break;
            case '2':
                $truePrice = $goodsBase['special_price'] / 100;
                break;

            default:
                $store = unserialize(Cache::get('store'.STOREID));
                $truePrice = bcmul($store['default_discount'], $goodsDetail['price'], 0) / 100;
                break;
        }

        $data = $goodsDetail;
        $data['id'] = $goodsBase['id'];
        $data['state'] = $goodsBase['state'];
        $data['goodsAmount'] = $goodsBase['goods_amount'];
        $data['orderedCount'] = $goodsBase['ordered_count'];
        $data['truePrice'] = $truePrice;
        $data['price'] = $goodsDetail['price'] / 100;

        return $data;
    }

}