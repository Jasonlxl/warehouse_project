<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/3/28
 * Time: 18:18
 */

namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function index(){
//        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        $this->display();
    }

    public function easyuiDataGrid(){
        $this->display();
    }

    public function getDataGrid(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $model = M('User');
        $row = $model->count();
        $result["total"] = $row;

        $offset = ($page-1)*$rows;

        $rs = $model->order('id desc')->limit($offset,$rows)->select();

        $result["rows"] = $rs;

        echo json_encode($result);
    }

    public function editDataGrid(){

        $data['id'] = intval($_GET['id']);
        $data['username'] = htmlspecialchars($_REQUEST['username']);
        $data['password'] = md5(htmlspecialchars($_REQUEST['password']));
        $data['login_time'] = time();
        $data['status'] = htmlspecialchars($_REQUEST['status']);
        foreach( $data as $k=>$v){
            if( $v == null ) unset($data[$k]);
        }
        $model = M('User');

        if($model->save($data)){
            echo json_encode(array(
                'id' => $data['id'],
                'username' => $data['username'],
                'password' => $data['password'],
                'login_time' => $data['login_time'],
                'status' => $data['status']
            ));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }

    }

    public function addDataGrid(){

        $data['username'] = htmlspecialchars($_REQUEST['username']);
        $data['password'] = md5(htmlspecialchars($_REQUEST['password']));
        $data['login_time'] = time();
        $data['status'] = htmlspecialchars($_REQUEST['status']);
        $model = M('User');
        $id = $model->add($data);

        if($id){
            echo json_encode(array(
                'id' => $id,
                'username' => $data['username'],
                'password' => $data['password'],
                'login_time' => $data['login_time'],
                'status' => $data['status']
            ));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }

    }

    public function delDataGrid(){
        $data['id'] = intval($_REQUEST['id']);
        $model = M('User');
        if($model->where($data)->delete()){
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('errorMsg'=>'Some errors occured.'));
        }
    }

    public function resetPass($id){
        $model = M('User');
        $data['id'] = $id;
        $data['password'] = md5(rand(10000,999999));
        $data['login_time'] = time();
        if($model->save($data)){
            $this->success("重置成功！");
        }else{
            $this->error("重置失败！");
        }
    }
}