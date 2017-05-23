<?php

namespace app\api\controller;

use think\Controller;
use think\Cache;
//use think\Request;
use app\api\logic\Store;
class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();

        //初始化店铺信息、设置
        $sys_arr = explode('.', $_SERVER['SERVER_NAME']);
        if(!empty($sys_arr[3]) && $sys_arr[3] == 'com'){
            $store_id = $sys_arr[0];

            define('STOREID',intval($store_id));

            if(STOREID <= 0){
                exit;
            }

            $store = Cache::get('store'.STOREID);
            if(empty($store)) {
                $logic = new controller('Store', 'logic');

                $store = $logic->getStoreSet(STOREID);

                if (empty($store)) {
                    echo '不存在';
                    exit;
                }
                if ($store['store_switch'] == 0) {
                    echo '已关闭';
                    exit;
                }

                //加入缓存
                Cache::set('store' . STOREID, serialize($store), 3600);
            }

        }else{
            echo 'no store id';
            exit;
        }

        //初始化用户

    }
}
