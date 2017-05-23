<?php
namespace app\api\controller;
use think\Controller;
//use app\common\Base;
//class Index extends Base
use app\api\model\Store;
class Index extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    public function test(){
//        $aaa = new Store;
//        $aaa->geti();exit;
//    	echo 13;

    	//$DD = controller('service/Test', 'controller');
        //$a = \controller('libraries/Ca', '');
        $a = \controller('store', 'logic');
        $a->getStoreSet(1);
//    var_dump($a);exit;
//    	echo $DD->index();
    }

    public function aa(){
        echo 22;
    }
}
