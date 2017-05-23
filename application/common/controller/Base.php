<?php
namespace app\common\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();

        //初始化店铺设置
        $sys_arr = explode('.', $_SERVER['SERVER_NAME']);
        if(!empty($sys_arr[3]) && $sys_arr[3] == 'com'){
            $store_id = $sys_arr[0];
            define('STOREID',intval($store_id));

            $store_info = Redis::get('store'.STOREID);
            $store_info = '';
            if(empty($store_info)){

                $storeModel = new Store;
                $store_info = $storeModel->getStoreSet(STOREID);
                Redis::set('store'.STOREID,serialize($store_info));
            }
            //$res = Redis::get('store'.STOREID);

        }else{
            echo 'no store id';
            exit;
        }
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        echo 'test';
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
