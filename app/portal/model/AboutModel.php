<?php



namespace app\portal\model;


use think\Model;


class AboutModel extends Model
{
    
    public function getAimgAttr($value){
        
        return "https://ztx.hfxyzq.cn/upload/".$value;
    }
    
}