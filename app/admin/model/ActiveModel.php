<?php

namespace app\admin\model;

use think\Model;

class ActiveModel extends Model
{

 public function getPextendAttr($data){
     
     return json_decode($data,true);
 }
}