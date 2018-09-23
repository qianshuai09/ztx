<?php


namespace app\admin\model;

use think\Model;

class MuserModel extends Model
{
    
    public function getMuImgAttr($data){
     
     return json_decode($data,true);
     
    }
}