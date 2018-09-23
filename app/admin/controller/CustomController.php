<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2018/4/25
 * Time: 16:12
 */

namespace app\admin\controller;
use app\portal\model\CustomModel;


use cmf\controller\AdminBaseController;

/*
 * 后台客户管理
 *
 */

class CustomController extends AdminBaseController
{
    /**
     * 后台客户列表
     * 
     * 
     */
    public function index(){
        $custom_model = new CustomModel();
        $custom = $custom_model->order('uid','DESC')->paginate(10);
        $this->assign('custom',$custom);
        $this->assign('page', $custom->render());
        return $this->fetch();
    }
    
    
    /**
     * 后台客户删除
     * 
     * 
     */
     public function delete(){
           $id = $this->request->param('id');
          $custom_model = new CustomModel();
          $custom = $custom_model->where('uid',$id)->delete();
          if($custom){
              $this->success("用户删除成功！");
          }else{
              $this->error("用户删除失败！");
          }
     }
     
     /**
      * 认证审核页面
      * 
      * 
      */
      public function checkid(){
         $id             = $this->request->param('id');
         $custom_model = new CustomModel();
         $custom = $custom_model->where('uid',$id)->field('uid,name,idnumber,clubphoto,stuphoto,status,front,back')->find();
         $this->assign('custom',$custom);
        return $this->fetch();
     
      }
      
     /**
      * 认证审核成功
      * 
      * 
      */
      public function passId(){
          $id = $this->request->param('id');
          $custom_model = new CustomModel();
          $custom = $custom_model->where('uid',$id)->update(['status'=>2]);
          if($custom){
              echo 1; //认证通过成功
          }else{
              echo 2; //认证通过失败
          }
      }
      
     /**
      * 认证审核驳回
      * 
      * 
      */
      public function backId(){
          $id = $this->request->param('id');
          $custom_model = new CustomModel();
          $custom = $custom_model->where('uid',$id)->update(['status'=>3]);
          if($custom){
              echo 1; //认证通过成功
          }else{
              echo 2; //认证通过失败
          }
      }
      
      /**
       * 客户查找
       * 
       * 
       */
       public function select($key){
           $custom_model = new CustomModel();
           $custom = $custom_model->where('wx_name','=',$key)->find();
           if($custom){
               $this->assign("custom",$custom);
               return $this->fetch();
           }else{
               $cu = $custom_model->where('name','=',$key)->find();
               if($cu){
                   $this->assign('custom',$cu);
                   return $this->fetch();
               }else{
                   $this->error("没有此客户！");
               }
           }
       }
     
     
}