<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\logic\Token;
use app\api\logic\User as UserLogic;
class User extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function login(){
        $logic = new Token;
        $openid = 'zzzzzzzzzzzzzzzzzzzzz';
        $access_token = $logic->getAccessToken(1,$openid);
    dump($access_token);
    }

    public function getuser(){
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjEsInN0b3JlSWQiOjEsImlzcyI6Ind3dy5iYWlkdS5jb20iLCJpYXQiOjE0OTUxNzY3Mzl9.Sja4QBnEaFjNL4VesU6l6WJnqp5bH1Upr-bheOhmtgQ';
        $logic = new Token;
        $res = $logic->checkAccessToken(1,$access_token);
        var_dump($res);
    }

    /**
     * 添加收货地址(每人最多添加10条)
     * @param
     * @return \think\Response
     */
    public function addAddress(){
        $data = Request::instance()->param('');


        $data['user_id'] = $userId;
        $UserLogic = new UserLogic;

        //检查收货地址总数
        $count = $UserLogic->getAddresssCount($userId);
        if($count >= 10){
            return ['code'=>2,'message'=>'最多添加10条收货地址'];
        }
        $res = $UserLogic->addAddress($data);
        if($res == 0){
            return ['code'=>0,'message'=>'请填写完整信息'];
        }
        if($res == 1){
            return ['code'=>1,'message'=>'ok'];
        }
        if($res == -1){
            return ['code'=>0,'message'=>'添加失败'];
        }
    }

    /**
     * 删除收货地址
     * @param $id
     * @return \think\Response
     */
    public function delAddress(){
        $id = Request::instance()->param('id');
        $data['id'] = $id;
        $data['user_id'] = $userId;

        $UserLogic = new UserLogic;
        $res = $UserLogic->delAddress();
        if($res == 0){
            return ['code'=>0,'message'=>'操作失败'];
        }
        if($res == 1){
            return ['code'=>1,'message'=>'ok'];
        }
    }

    /**
     * 编辑收货地址
     * @param $id
     * @return \think\Response
     */
    public function editAddress(){
        $id;
        $data;
        $map['id'] = $id;
        $map['user_id'] = $userId;

        $UserLogic = new UserLogic;
        $res = $UserLogic->editAddress($map, $data);
        if($res == 0){
            return ['code'=>0,'message'=>'操作失败'];
        }
        if($res == 1){
            return ['code'=>1,'message'=>'ok'];
        }
    }

    /**
     * 获取收货地址列表
     * @return \think\Response
     */
    public function getAddressList(){
        $UserLogic = new UserLogic;
        $res = $UserLogic->getAddressList($userId);

        retrun ['code'=>1,'message'=>'ok','data'=>$res];
    }
}
