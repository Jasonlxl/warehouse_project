<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/4/8
 * Time: 16:13
 */
namespace Home\Controller;
use Think\Controller;

class PublicController extends Controller{

    public function _initialize(){
        $action = strtolower(ACTION_NAME);
        $uid = session('user_id');
        if($uid && $action != 'logout'){
            $this->success('您已登录成功',U('Index/index'),1);
            exit;
        }
    }

    public function login(){
        $this->display();
    }

    public function index(){
        $post = I('post.');
        if(!empty($post)){
            $model = M('admin');
            $map['user_name'] = $post['user_name'];
            $check = $model->where($map)->find();
            if(!empty($check)){
                if($check['password'] == md5($post['password'])){
                    session('user_id',$check['id']);
                    session('username',$check['user_name']);
                    session('password',$check['password']);
                    $this->success('登陆成功啦！',U('Index/index'),1);
                }else{
                    $this->error('密码有误！',U('login'),1);
                }
            }else{
                $this->error('没有这个用户哟！',U('login'),1);
            }

        }else{
            $this->error('数据传输失败！',U('login'),1);
        }
    }

    public function logout(){
        session(null);
        $this->success('登出成功',U('login'),1);
    }
}