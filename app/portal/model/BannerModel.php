<?php

namespace app\portal\model;


use think\Model;


class BannerModel extends Model
{
    
     public function getBimageAttr($data){
     
     return json_decode($data,true);
 
     
  }
}

