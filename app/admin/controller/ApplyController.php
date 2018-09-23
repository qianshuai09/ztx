<?php

namespace app\admin\controller;
use app\portal\model\ActiveModel;
use app\admin\model\StationModel;
use app\admin\model\MuserModel;
use app\admin\model\OrderModel;

use cmf\controller\AdminBaseController;

class ApplyController extends AdminBaseController
{
    /**
     * 活动申请列表
     *
     */
     public function activeApply(){
         $orderModel = new OrderModel();
         $order = $orderModel
                         ->alias("a")
                         ->join('ztx_custom b','a.ouid = b.uid')
                         ->join('ztx_active c','a.opid = c.pid')
                         ->where('pcategory',3)
                         ->field("a.oid,a.create_time,b.wx_name,b.phone,b.name,c.pname,c.ptitle")
                         ->paginate(10);
         $this->assign('page',$order->render());
         $this->assign("order",$order);
         return $this->fetch('active');
     }
     
     
    /*
     * 删除
     *
     */
    public function delete(){
        
        $product_model = new OrderModel();
        $data            = $this->request->param();

        $result = $product_model->where(['oid'=>$data['id']])->delete();

        if ($result) {
            
            $this->success(lang('DELETE_SUCCESS'));
        } else {
            $this->error(lang('DELETE_FAILED'));
        }
    }
    
    public function deleteApply(){
         $product_model = new MuserModel();
        $data            = $this->request->param();

        $result = $product_model->where(['mu_id'=>$data['id']])->delete();

        if ($result) {
            
            $this->success(lang('DELETE_SUCCESS'));
        } else {
            $this->error(lang('DELETE_FAILED'));
        }
    }
     
     /**
      * 赞助申请列表
      * 
      */
      public function donateApply(){
         $orderModel = new OrderModel();
         $order = $orderModel
                         ->alias("a")
                         ->join('ztx_custom b','a.ouid = b.uid')
                         ->join('ztx_active c','a.opid = c.pid')
                          ->where('pcategory',1)
                         ->field("a.oid,a.create_time,b.wx_name,b.phone,b.name,c.pname,c.ptitle")
                         ->paginate(10);
         $this->assign("order",$order);
         
         return $this->fetch('donate'); 
      }
      
      /**
       * 岗位申请列表
       * 
       */
       public function stationApply(){
         
         $muserModel = new MuserModel();
         
         $muser = $muserModel
                        ->alias("a")
                        ->join('ztx_custom b','a.mu_uid = b.uid')
                        ->join('ztx_station c','a.mu_mid = c.mid')
                        ->join('ztx_active d','c.mcate = d.pid')
                        ->field('a.mu_id,a.create_time,b.wx_name,b.phone,b.name,d.pname,c.mname')
                        ->paginate(10);
        $this->assign("page",$muser->render());
        $this->assign('muser',$muser);                
           
        return $this->fetch('station');
       }
       
       
       /*申请回复页面*/
       public function reply(){
           $data            = $this->request->param();
           $orderModel = new OrderModel();
           $order = $orderModel->where("oid",$data["id"])->find();
           $pimgs = $order['oimg'];
           $this->assign('img',$pimgs);
           $this->assign("order",$order);
           return $this->fetch();
       }
       
       
       /*申请回复提交*/
       public function replyPost(){
           $data = $this->request->param();
           $orderModel = new OrderModel();
           if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $datas['purl'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($datas['purl'], ["url" => $photoUrl]);
                }
                
               //将二维数组转换成字符串对象存入数据库
               $pimges =  json_encode($datas['purl']);
               
               $dataw = [
                   "ocontent"=>$data['ocontent'],
                   "oimg"=>$pimges
                   
                   ];
                   
           $order = $orderModel->where("oid",$data["oid"])->update($dataw);
           if($order){
               $this->success("回复成功");
           }else{
               $this->error("回复失败");
           }
               
           }
           
       }
       
       
       public function replyWork(){
            $data            = $this->request->param();
            $muserModel = new MuserModel();
            $muser  = $muserModel->where("mu_id",$data['id'])->find();
            $mimg = $muser["mu_img"];
            $this->assign('img',$mimg);
            $this->assign("muser",$muser);
            return $this->fetch();
       }
       
       
        /*申请回复提交*/
       public function replyWorkPost(){
           $data = $this->request->param();
           $muserModel = new MuserModel();
           if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $datas['purl'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($datas['purl'], ["url" => $photoUrl]);
                }
                
               //将二维数组转换成字符串对象存入数据库
               $pimges =  json_encode($datas['purl']);
               
               $dataw = [
                   "mu_back"=>$data['mu_back'],
                   "mu_img"=>$pimges
                   
                   ];
                   
           $order = $muserModel->where("mu_id",$data["muid"])->update($dataw);
           if($order){
               $this->success("回复成功");
           }else{
               $this->error("回复失败");
           }
         }
           
       }
}
