<?php

namespace app\portal\model;


use think\Model;


class ActiveModel extends Model
{
    
    public function getPimgAttr($value){
        
        return "https://ztx.hfxyzq.cn/".$value;
    }
    
}
