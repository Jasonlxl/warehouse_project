<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2019/1/7
 * Time: 11:02
 */

namespace Home\Controller;
use Think\Controller;
class OrderInController extends CommonController {
    public function index(){
//        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        $this->display();
    }

    public function OrderInDataGrid(){
        $this->assign('user_name',$_SESSION['username']);
        $this->display();
    }

    public function apiTest(){
        var_dump($_SESSION['user_id']);
        $this->display();
    }

    public function getGoodsName(){
        $model = M('Warehouse');
        $goodsNameList = $model->field('id,name')->select();
        echo json_encode($goodsNameList);
    }

    public function getDataGrid(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $model = M('Order');
        $row = $model->count();
        $result["total"] = $row;

        $offset = ($page-1)*$rows;

        $map['ordermark'] = 0;

        $rs = $model->where($map)->order('id desc')->limit($offset,$rows)->select();

        $result["rows"] = $rs;

        echo json_encode($result);
    }

    public function antiDataGrid(){

        $data['id'] = intval($_GET['id']);
        $data['name'] = $_REQUEST['name'];
        $data['abbreviation'] = $_REQUEST['abbreviation'];
        $data['unit'] = $_REQUEST['unit'];
        $data['price'] = $_REQUEST['price'];
        foreach( $data as $k=>$v){
            if( $v == null ) unset($data[$k]);
        }
        $model = M('Warehouse');

        if($model->save($data)){
            echo json_encode(array(
                'id' => $data['id'],
                'name' => $data['name'],
                'abbreviation' => $data['abbreviation'],
                'unit' => $data['unit'],
                'price' => $data['price']
            ));
        } else {
            echo json_encode(array('errorMsg'=>'Error to Edit'));
        }

    }

    public function addDataGrid(){

        $data['goodsname'] = $_REQUEST['goodsname'];
        $data['goodsquantity'] = $_REQUEST['goodsquantity'];
        $data['username'] = $_REQUEST['username'];
        $data['ordermark'] = 0;

        $data['orderno'] = date("Ymd").time();
        $model = M('order');
        $id = $model->add($data);

        $model_goods = M('Warehouse');
        $data_goods['name'] = $data['goodsname'];
        $res = $model_goods->where($data_goods)->select();

        $data_goods['id'] = $res[0]['id'];
        $quantity = (int)$res[0]['quantity'] + $data['goodsquantity'];
        $data_goods['quantity'] = (String)$quantity;

        if($model_goods->save($data_goods)){
            if($id){
                echo json_encode(array(
                    'id' => $id,
                    'orderno' => $data['orderno'],
                    'goodsname' => $data['goodsname'],
                    'goodsquantity' => $data['goodsquantity'],
                    'username' => $data['username'],
                ));
            } else {
                echo json_encode(array('errorMsg'=>'Error to AddOrder!'));
            }
        }else{
            echo json_encode(array(
                'errorMsg'=>'Error to AddOrder!'
            ));
        }

    }

}