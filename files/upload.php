<?php

if($_FILES["file"]["error"])
{
    echo $_FILES["file"]["error"];
}
else
{

    if($_FILES["file"]["size"]<10240000)
    {
        //防止文件名重复
        $filename = "./a/".time().$_FILES["file"]["name"];
        //转码
        $filename = iconv("UTF-8","gb2312",$filename);

        if(file_exists($filename))
        {
            echo "该文件已存在";
        }
        else
        {
            //保存文件
            move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
            header("location:wenjianchuanshu.php");
        }
    }
    else
    {
        echo "文件类型不对";
    }
}