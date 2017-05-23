<?php
/**
 * Created by PhpStorm.
 * User: shihuan
 * Date: 2017/5/18
 * Time: 14:37
 */

namespace app\api\logic;

use Firebase\JWT\JWT;
use think\Db;
//use firebase\JWT;
use Think\Config;
use think\Cache;
class Token
{
    /**
     * 登陆生成access_token
     * @param $storeId
     * @param $openid
     * @return str
     */
    public function getAccessToken($storeId, $openid){
        $map['openid'] = $openid;
        $user = Db::name('user')->where($map)->find();
        if(empty($user)){
            return false;
        }
        if($user['state'] == 1){
            return -1;
        }

        //生成accesstoken
        $token = [
            'userId' => $user['id'],
            'storeId' => $storeId,
            'iss' => 'www.baidu.com',
            'iat' => time()
        ];
        vendor('firebase.JWT');

        $access_token = JWT::encode($token, Config::get('jwt_key'));

        //加入缓存
        Cache::set(Config::get('USER_LOGIN_CACHE_PREFIX').$user['id'],$access_token,Config::get('LOGIN_TIMEOUT'));

        return $access_token;
    }

    /**
     * 验证access_token，返回userId
     * @param $access_token
     * @param $storeID
     * @return arr
     */
    public function checkAccessToken($storeId, $access_token){
        $token = JWT::decode($access_token, Config::get('jwt_key'), array('HS256'));

        if(empty($token) || empty($token->userId)){
            return ['code'=>0];
        }

        if($token->storeId != $storeId){
            //不能垮店铺登陆
            return ['code'=>0];
        }

        //对比缓存
        $jwt = Cache::get(Config::get('USER_LOGIN_CACHE_PREFIX').$token->userId);

        if(empty($jwt) || $access_token != $jwt){
            //无效的access_token
            return ['code'=>0];
        }

        //刷新登陆超时时间
        Cache::set(Config::get('USER_LOGIN_CACHE_PREFIX').$token->userId ,$access_token,Config::get('LOGIN_TIMEOUT'));

        return ['code'=>1,'userId'=>$token->userId];

    }

}