<?php

function cutAndEncodetoUTF($cellvalue)
{
    $cellvalue= mb_convert_encoding($cellvalue, "UTF-8");
    //var_dump(strpos($cellvalue, ', шт')>64);

    if (iconv_strpos($cellvalue, ', шт',0,'UTF-8')>64){
    $cellvalue = iconv_substr($cellvalue, 0,64,'UTF-8');
    } else{
        $cellvalue = iconv_substr($cellvalue,0, iconv_strpos($cellvalue, ', шт',0,'UTF-8'));
    }





    return $cellvalue;
}


/**
 * Created by PhpStorm.
 * User: Obmor
 * Date: 11.11.2018
 * Time: 12:19
 */