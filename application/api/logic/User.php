<?php
/**
 * Created by PhpStorm.
 * User: shihuan
 * Date: 2017/5/19
 * Time: 17:23
 */

namespace app\api\logic;

use think\Db;
class User
{
    /**
     * 添加收货地址
     * @param data
     * @return arr
     */
    public function addAddress($data){
        //验证
        if(empty($data['province']) || empty($data['province']) || empty($data['area']) || empty($data['name']) || empty($data['mobilephone'])){
            return 0;
        }

        $data['createtime'] = $data['updatetime'] = time();

        if(Db::name('user_address')->add($data)){
            return 1;
        }else{
            return -1;
        }

    }

    /**
     * 删除收货地址
     * @param data
     * @return arr
     */
    public function delAddress($data){
        if($data['id'] <= 0){
            return 0;
        }

        $map['id'] = $data['id'];
        $map['user_id'] = $data['user_id'];

        if(DB::name('user_address')->where($map)->delete()){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 添加收货地址
     * @param $map
     * @param $data
     * @return arr
     */
    public function editAddress($map,$data){
        if($map['id'] <= 0){
            return 0;
        }
        //验证
        if(empty($data['province']) || empty($data['province']) || empty($data['area']) || empty($data['name']) || empty($data['mobilephone'])){
            return 0;
        }

        $data['updatetime'] = time();

        if(Db::name('user_address')->where($map)->update($data)){
            return 1;
        }else{
            return -1;
        }

    }

    /**
     * 获取收货地址总数
     * @param $userId
     * @return str
     */
    public function getAddressCount($userId){
        $map['user_id'] = $userId;
        $count = Db::name('user_address')->where($map)->count();

        return $count;
    }

    /**
     * 获取收货地址列表
     * @param $userId
     * @return str
     */
    public function getAddressList($userId){
        $map['user_id'] = $userId;
        $data = Db::name('user_address')->where($map)->select();

        return $data;
    }
}