<?php

namespace app\portal\model;


use think\Model;


class OrderModel extends Model
{
     public function getOimgAttr($data){
     
     return json_decode($data,true);
     }
    
}

