<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/4/8
 * Time: 15:58
 */
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller{

    public function _initialize(){

        $uid = session('user_id');

        if(empty($uid)){
            $url = U('Public/login');
            echo "<script>top.location.href='$url';</script>";
            exit;
        }
    }
}