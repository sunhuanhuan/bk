<?php
/**
 * Created by PhpStorm.
 * User: shihuan
 * Date: 2017/5/20
 * Time: 13:58
 */

namespace app\api\logic;

use think\Db;
use think\Cache;
class Category
{
    /**
     * 获取分类
     *
     * @return arr
     */
    public function getCategory(){
        $data = Cache::get('category');

        if(empty($data)){
            $data = [];
            $res = Db::name('category')->select();
            foreach ($res as $value){
                if($value['parent_id'] == 0){
                    $arr = ['id'=>$value['category_id'],'name'=>$value['category_name']];
                    array_push($data,$arr);
                }

            }
            //dump($data);exit;
            foreach ($data as &$value){
                foreach ($res as $v){
                    if($value['id'] == $v['parent_id']){
                        $value['son'][] = ['id'=>$v['category_id'],'name'=>$v['category_name']];
                    }
                }
            }

            $data = serialize($data);
            Cache::set('category',$data,600);
        }

        $data = unserialize($data);

        return $data;
    }
}