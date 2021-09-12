<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 用户自定义函数库
// +----------------------------------------------------------------------
function writeLog($msg,$folder = 'default')
{
    $date = date('Y-m-d');
    $path = "Log/".$folder;
    $filename = $date.".txt";
    if(is_object($msg))
        $strdata = var_export((array)$msg,TRUE);
    else
        $strdata = var_export($msg,TRUE);
    $str = date('Y-m-d H:i:s')."\r\n".$strdata."\r\n";
    if(!file_exists($path)){
        mkdir($path,0777,true);
    }
    $file = fopen($path."/".$filename, "a") or die("Unable to open log file!");
    fwrite($file, $str);
    fclose($file);
}