<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>文件</title>
    <link href="../FENGZHUANG/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="../FENGZHUANG/jquery-3.1.1.min.js"></script>
    <script src="../FENGZHUANG/bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
        *{
            font-family:"微软雅黑";}
        #wai{width:400px;
            margin:0 auto;
            padding:0px;}
        #chuanshu{
            width:400px;
            margin:0 auto;
            padding:0px;}
        .waibtn{
            width:100%;;
            height:30px;}
        .wjm,.wjbtn{
            width:50%;
            height:100%;
            float:left;
        }
    </style>
</head>

<body>
<div id="chuanshu">
    <form role="form" action="upload.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputfile">文件输入</label>
            <input type="file" name="file" id="inputfile">
        </div>
        <button type="submit" class="btn btn-default">上传</button>
    </form>
</div>
<br /><br /><br />
<div id="wai">
    <?php
    session_start();
    //定义目录
    $fname = "./a";//需要显示的目录
    if(!empty($_SESSION["fname"]))
    {
        $fname = $_SESSION["fname"];
    }

    $pname = dirname($fname); //取上级目录

    if(realpath($fname)=="D:\\wamp\\www\\lt\\a")//注意路径的匹配
    {
    }//到达了需要显示的最上层目录就不显示上一层标签了
    else
    {
        echo "<button type='button' id='prev' class='btn waibtn btn-success' url='{$pname}'>返回上一层</button>";
    }
    //遍历目录下的所有文件显示
    $arr = glob($fname."/*");

    foreach($arr as $v)
    {
        $name = basename($v); //从完整路径中取文件名
        $name = iconv("gbk","utf-8",$name);
        if(is_dir($v))
        {
            echo "<button type='button' class='btn dir waibtn btn-primary' url='{$v}'>{$name}</button>";
        }
        else
        {
            echo "<button type='button' class='btn waibtn item btn-default' url='{$v}'><div class='wjm'>{$name}</div><div class='wjbtn'><a href='download.php? url={$v}'><input type='button' value='下载' url='{$v}' class='download btn btn-warning btn-xs' /></a>&nbsp;&nbsp;</div></button>";
        }
    }

    ?>
</div>

</body>

<script type="text/javascript">
    $(".dir").click(function(){
        var url = $(this).attr("url");
        $.ajax({
            url:"chuli2.php",
            data:{url:url},
            type:"POST",
            dataType:"TEXT",
            success: function(data){
                window.location.href="wenjianceshi.php";
            }
        });
    })
    $("#prev").click(function(){
        var url = $(this).attr("url");
        $.ajax({
            url:"chuli2.php",
            data:{url:url},
            type:"POST",
            dataType:"TEXT",
            success: function(data){
                window.location.href="wenjianceshi.php";
            }
        });
    })</script>

</html>