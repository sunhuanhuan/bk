<?php

namespace app\base\model;

use think\Model;

class Store extends Model
{
    //

    /**
     * 根据id获取初始设置
     * @param store_id int
     */
    public function getStoreSet($store_id){
        if(empty($store_id) || $store_id <= 0){
            return false;
        }

        $filed = ['store_id','supplier_store_id','store_switch','store_name','store_logo_url','store_mobilephone','store_desc','announcement','default_discount'];

        $filed = ('store_id,supplier_store_id,store_switch,store_name,store_logo_url,store_mobilephone,store_desc,announcement,default_discount');

        $map['store_id'] = $store_id;
        $store = $this->field($filed)->where($map)->find();
        echo $store->store_id;
        print_r($store);exit;
        var_dump($store->attributes);exit;
        $store = $store->toArray();
        var_dump($store);exit;
        // if(empty($store)){
        //     echo '店铺不存在';
        //     exit;
        // }
        // //print_r($store);exit;
        // //关闭时
        // if($store['store_switch'] == 0){
        //     echo '店铺已关闭';
        //     exit;
        // }

        // //主店铺
        // if($store['supplier_store_id'] == 0){
        //     $store['type'] = 1;//主店铺
        // }else{//分销店铺
        //     $owner_store = $this->select($filed)->where('store_id', $store->supplier_store_id)->first();
        //     if(empty($owner_store)){
        //         echo '店铺不存在';
        //         exit;
        //     }
        //     $store = $owner_store;
        //     $store['type'] = 2;//分店铺
        //     $store['fen_store_id'] = $store_id;
        // }
        if(empty($store)){
            echo '店铺不存在';
            exit;
        }
        //print_r($store);exit;
        //关闭时
        if($store['store_switch'] == 0){
            echo '店铺已关闭';
            exit;
        }

        //主店铺
        if($store['supplier_store_id'] == 0){
            $store['type'] = 1;//主店铺
        }else{//分销店铺
            $owner_store = $this->select($filed)->where('store_id', $store->supplier_store_id)->first();
            if(empty($owner_store)){
                echo '店铺不存在';
                exit;
            }
            $store = $owner_store;
            $store['type'] = 2;//分店铺
            $store['fen_store_id'] = $store_id;
        }

        return $store;
    }
}
