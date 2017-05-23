<?php
/**
 * Created by PhpStorm.
 * User: shihuan
 * Date: 2017/5/12
 * Time: 11:32
 */

namespace app\api\logic;
use think\Cache;
use app\api\model\Store as StoreModel;
class Store
{

    /**
     * 根据id获取初始设置
     * @param store_id int
     */
    public function getStoreSet($store_id){
        if(empty($store_id) || $store_id <= 0){
            return false;
        }

        $filed = ('store_id,supplier_store_id,store_switch,store_name,store_logo_url,store_mobilephone,store_desc,announcement,default_discount');

        $Model = new StoreModel;

        $map['store_id'] = $store_id;

        $store = $Model->field($filed)->where($map)->find();

        return $store;
    }

}