<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use cmf\controller\HomeBaseController;
use app\portal\model\ActiveModel;
use app\portal\model\CustomModel;
use app\portal\model\CategoryModel;
use app\portal\model\OrderModel;
use app\portal\model\BannerModel;
use app\portal\model\LoveModel;
use app\portal\model\JoinModel;
use app\admin\model\MuserModel;
use app\portal\model\AboutModel;
use app\admin\model\StationModel;
use think\Db;
use think\Controller;


class WxController extends Controller
{
    
    protected $appId;
    protected $appSecret;
    public function __construct()
    {
        $this->appId = 'wxbc9f185b34f2dc64';
        $this->appSecret = '6d8d4badde0476c2c3fbd09164dbbbfd';
    }
    /*
     * 获取用户的openid
     * param  微信  code码
     *
     */
    public function wxData($code)
    {
        
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appId."&secret=".$this->appSecret."&js_code=".$code."&grant_type=authorization_code";

        $data = array();
        $header = array();
        $response = $this->curl_https($url, $data, $header, 5);

        //sp_log($response);
        $rsObj=json_decode($response,1);
        echo json_encode($rsObj);
        exit();
    }
    

     /*
     * 获取access_token(success)
     *
     */
     public function token(){
         
         $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appSecret."";
         $data = array();
         $header = array();
         $response = $this->curl_https($url, $data);
         $data = json_decode($response,1);
         return $data;
     }
     
    /*
     * 添加微信用户信息(success)
     * @ param    微信openid   微信头像：avatar  微信昵称：nickname
     *
     */
    public function infoAdd($openid,$avatar,$nickname)
    {
        $userModel = new  CustomModel();
        $result = $userModel->where('wx_openid',$openid)->find();
        if ($result) {
            $data['uid']= $result->uid;
            echo json_encode($data);
            exit();
        } else {
            $res["wx_openid"] = $openid;
            $res["wx_img_url"] = $avatar;
            $res["wx_name"] = $nickname;
            $res["create_time"] = time();
            $result = $userModel->insert($res);
            if ($result) {
                $data['uid']= $result['uid'];
                echo json_encode($data);
                
                exit();
            } else {
                  $msg = array(
                    "code"=> 4000,
                    "error" =>"插入失败"
                    );
                echo json_encode($msg);
                exit();
            }
        }
    }
    
    
    /**
     * 首页轮播图
     * 
     */
     public function banner(){
         $bannerModel = new BannerModel();
         $banner = $bannerModel->where('bid',1)->find();
         $pimgs = $banner['bimage'];
         $data['urls'] = [];
         if(is_array($pimgs)){
             foreach ($pimgs as $key => $value) {
                 $photoUrl = cmf_get_image_url($value['url']);
                 array_push($data['urls'], ['url' => $photoUrl]);
             }
         }

        echo json_encode($data);
         exit();
     }
    
    
    /**
     * 获取所有的分类列表
     * 
     */
     public function category(){
         $categoryModel = new CategoryModel();
         $category = $categoryModel->select();
         echo json_encode($category);
         exit();
     }
     
   /**
     * 点击某一分类展示产品列表
     * 
     */
     public function activeCategory($cid,$openid){
         $activeModel = new ActiveModel();
        //  $active = $activeModel->where('pcategory',$cid)->select();
         
        $customModel = new CustomModel();
        $custom = $customModel->where('wx_openid',$openid)->find();
        $uid = $custom['uid'];
        $active = Db::query("SELECT a.pid,a.plove,a.pprice,a.pwork,a.pname,a.ptitle,a.pimg,a.pdetail,a.pextend,b.laid,c.opid FROM (SELECT * from ztx_active where pcategory ='$cid') a LEFT JOIN (select * from ztx_love WHERE luid='$uid') b on b.laid = a.pid LEFT JOIN (SELECT * FROM ztx_order where ouid ='$uid') c on c.opid =a.pid GROUP BY a.pid; ");
         echo json_encode($active);
         exit();
     }
     
     /**
      * 某一个产品的详情页
      * 
      */
      public function detail($pid,$openid){
          
        $customModel = new CustomModel();
        $custom = $customModel->where('wx_openid',$openid)->find();
        $uid = $custom['uid'];
        $active = Db::query("SELECT a.pid,a.atime,a.alocation,a.abeizhu,a.starttime,a.endtime,a.zanzhu,a.pname,a.ptitle,a.pimg,a.pdetail,a.pextend,b.laid,c.opid FROM (SELECT * from ztx_active where pid ='$pid') a LEFT JOIN (select * from ztx_love WHERE luid='$uid') b on b.laid = a.pid LEFT JOIN (SELECT * FROM ztx_order where ouid ='$uid') c on c.opid =a.pid GROUP BY a.pid; ");
    
        $pimgs = $active[0]['pextend'];
        
        $pi = $active[0]['pimg'];
        $img = cmf_get_image_url($pi);
        $p = json_decode($pimgs,true);
        
        $d['purl'] = [];
        if(is_array($p)){
        foreach ($p as $key => $value) {
            $photoUrl = cmf_get_image_url($value['url']);
            array_push($d['purl'], ['url' => $photoUrl]);
           }
        }
        
        $data['img']=$img;
        $data['data']=$active;
        $data['pimgs'] = $d;
        
        echo json_encode($data);
        exit();
      }
      
      
      
      /**
       * 实习工作的详情页
       * 
       */
       public function detailJob($pid,$openid){
             $customModel = new CustomModel();
        $custom = $customModel->where('wx_openid',$openid)->find();
        $uid = $custom['uid'];
          $job = Db::query("SELECT * FROM  (SELECT * from ztx_station WHERE mcate='$pid') a LEFT JOIN (select * from ztx_muser WHERE mu_uid='$uid')b on a.mid = b.mu_mid GROUP BY a.mid");
        
        $activeModel = new ActiveModel();
        $active = Db::query("SELECT a.pid,a.pname,a.pimg,a.pdetail,b.laid,c.opid FROM (SELECT * from ztx_active where pid ='$pid') a LEFT JOIN (select * from ztx_love WHERE luid='$uid') b on b.laid = a.pid LEFT JOIN (SELECT * FROM ztx_order where ouid ='$uid') c on c.opid =a.pid GROUP BY a.pid; ");
        $data['active'] =$active;
        $data['job']=$job;
        echo json_encode($data);
        exit();
       }
      
      /**
       * 点击喜欢按钮
       * 
       */
       public function love($openid,$pid){
          $activeModel = new ActiveModel();
          $loveModel = new LoveModel();
          $active = $activeModel->where('pid',$pid)->setInc('plove');
          
          $customModel = new CustomModel();
          $custom = $customModel->where('wx_openid',$openid)->find();
          
          $ex = $loveModel->where(['luid'=>$custom['uid'],'laid'=>$pid])->find();
           
          
          if(!$ex){
            
               $data = [
               'luid'=>$custom['uid'],
               'laid'=>$pid,
               'create_time'=>date('Y-m-d h:i:sa')
               ];
               
          
            $love = $loveModel->insert($data);
            
            if($love){
                $msg = array(
                    "code"=> 1000,
                    "success" =>"喜欢成功"
                    );
                echo json_encode($msg);
                exit(); 
            }
               
          }else{
             $msg = array(
                    "code"=> 4005,
                    "error" =>"已经喜欢"
                    );
                echo json_encode($msg);
                exit();
          }
       }
       
       /**
        * 点击申请按钮
        *
        */
        public function apply($openid,$pid){
           $customModel = new CustomModel();
           $custom = $customModel->where('wx_openid',$openid)->find();
           
           $orderModel = new OrderModel();
           
           $or = $orderModel->where(['ouid'=>$custom['uid'],'opid'=>$pid])->find();
           
           if(!$or){
              
           
           $data = [
               'ouid'=>$custom['uid'],
               'opid'=>$pid,
               'create_time'=>date('Y-m-d h:i:sa')
               ];
               
               
            
            $order = $orderModel->insert($data);
            if($order){
                $msg = array(
                    "code"=> 1000,
                    "success" =>"申请活动成功"
                    );
                echo json_encode($msg);
                exit();
            }else{
               $msg = array(
                    "code"=> 4000,
                    "error" =>"申请活动失败"
                    );
                echo json_encode($msg);
                exit();
            }
            
           }else{
                $msg = array(
                    "code"=> 4005,
                    "error" =>"已经申请过了"
                    );
                echo json_encode($msg);
                exit();
           }
        }
        
        
    /**
     * 点击申请工作按钮
     * 
     */
     public function applyJobButton($openid,$mid){
         $customModel = new CustomModel();
         $custom = $customModel->where('wx_openid',$openid)->find();
         $stationModel = new StationModel();
         $station = $stationModel->where('mid',$mid)->find();
         $musermodel = new MuserModel();
         $muser = $musermodel->where(['mu_uid'=>$custom['uid'],'mu_mid'=>$mid])->find();
         if(!$muser){
                $data = [
               'mu_uid'=>$custom['uid'],
               'mu_mid'=>$mid,
               'mu_name'=>$station['mname'],
               'create_time'=>date('Y-m-d h:i:sa')
               ];
               
             $m = $musermodel->insert($data);
             
             if($m){
              $msg = array(
                    "code"=> 1000,
                    "success" =>"申请职位成功"
                    );
                echo json_encode($msg);
                exit();
            }else{
               $msg = array(
                    "code"=> 4000,
                    "error" =>"申请职位失败"
                    );
                echo json_encode($msg);
                exit();
            }
             
         }else{
            $msg = array(
                    "code"=> 4005,
                    "error" =>"已经申请过了"
                    );
                echo json_encode($msg);
                exit();  
         }
     }
        
    /**
     * 获取我的记录
     * 
     */
     public function myActive($openid,$cid){
        $customModel = new CustomModel();
        $custom = $customModel->where('wx_openid',$openid)->find();
        $orderModel = new OrderModel();
        $order = $orderModel->where('ouid',$custom['uid'])
                            ->alias('a')
                            ->join('ztx_active b','a.opid = b.pid')
                            ->where('b.pcategory',$cid)
                            ->select();
        echo json_encode($order);
        exit();
     }
     
     /**
      * 获取我的喜欢
      * 
      */
      public function myLove($openid,$cid){
          $customModel = new CustomModel();
          $custom = $customModel->where('wx_openid',$openid)->find();
          $loveModel = new LoveModel();
          $love = $loveModel->where('luid',$custom['uid'])
                            ->alias('a')
                            ->join('ztx_active b','a.laid = b.pid')
                            ->where('b.pcategory',$cid)
                            ->select();
          echo json_encode($love);
          exit();
      }
      
      
      /**
      * 获取我生请的工作
      * 
      */
      public function myWork($openid){
          $customModel = new CustomModel();
          $custom = $customModel->where('wx_openid',$openid)->find();
          $musermodel = new MuserModel();
          $muser = $musermodel->where('mu_uid',$custom['uid'])
                              ->alias("a")
                              ->join('ztx_station b','a.mu_mid = b.mid','LEFT')
                              ->join('ztx_active c','b.mcate = c.pid','LEFT')
                              ->select();
          echo json_encode($muser);
          exit();
      }
      
      
     
     
     
     
     /**
      * 删除我申请的某一个记录
      * 
      */
      public function deleteMyActive($openid,$pid){
        $customModel = new CustomModel();
        $custom = $customModel->where('wx_openid',$openid)->find();
        $orderModel = new OrderModel();
        $order = $orderModel->where(['ouid'=>$custom['uid'],'opid'=>$pid])->delete();
        if($order){
              $msg = array(
                    "code"=> 1000,
                    "success" =>"删除成功"
                    );
                echo json_encode($msg);
                exit();
        }else{
             $msg = array(
                    "code"=> 4004,
                    "error" =>"删除失败"
                    );
                echo json_encode($msg);
                exit();
        }
      }
      
      
      public function deleteMyWork($openid,$muid){
        $customModel = new CustomModel();
        $custom = $customModel->where('wx_openid',$openid)->find();
        $musermodel = new MuserModel();
        $muser = $musermodel->where(['mu_uid'=>$custom['uid'],'mu_id'=>$muid])->delete();
         if($muser){
              $msg = array(
                    "code"=> 1000,
                    "success" =>"删除成功"
                    );
                echo json_encode($msg);
                exit();
        }else{
             $msg = array(
                    "code"=> 4004,
                    "error" =>"删除失败"
                    );
                echo json_encode($msg);
                exit();
        }
      }
      
      
        
   /**
     * 上传图片接口
     *
     */
    public function upload(){
        
       $file = request()->file('file');
       if ($file) {
          $info = $file->move(ROOT_PATH . 'public' . DS . 'upload/card/');
          if ($info) {
          $file = $info->getSaveName();
          echo $file;
          exit();
        }
       }  
    }
    
    
    /**
     * 加入我们接口
     * 
     */
     public function joinUs($openid,$name,$idnum,$phone,$school,$card="",$photo,$idimg,$wxnum=""){
         $join_model = new JoinModel();
         $customModel = new CustomModel();
         $custom = $customModel->where('wx_openid',$openid)->find();
         $data = [
             
             'juid'=>$custom['uid'],
             'jname'=>$name,
             'jidnum'=>$idnum,
             'phone'=>$phone,
             'school'=>$school,
             'card'=>$card,
             'photo'=>$photo,
             'idimg'=>$idimg,
             'wxnum'=>$wxnum,
             'create_time'=>date('Y-m-d h:i:sa')
             
             ];
        $join = $join_model->insert($data);
         if($join){
              $msg = array(
                    "code"=> 1000,
                    "success" =>"加入成功"
                    );
                echo json_encode($msg);
                exit();
        }else{
             $msg = array(
                    "code"=> 4008,
                    "error" =>"加入失败"
                    );
                echo json_encode($msg);
                exit();
        }
           
         
     }
    
    /**
     * 团队介绍
     */
    public function about(){
        
        $aboutModel = new AboutModel();
        $about = $aboutModel->where('ab_id',1)->find();
        $photo = $about["aphoto"];
        
        $p = json_decode($photo,true);
        
        $d['purl'] = [];
        
        if(is_array($p)){
        foreach ($p as $key => $value) {
            $photoUrl = cmf_get_image_url($value['url']);
            array_push($d['purl'], ['url' => $photoUrl]);
           }
        }
        $data['about'] = $about;
        $data['photo'] = $d;
        echo json_encode($data);
        exit();
    }
    

     
    /*
     * 实名认证接口
     * 参数 身份证正面图片：front 反面图片：back    微信openid:openid  姓名 :name 手机号：phone  身份证号:idnumber
     *
     */
    public function certification($openid,$name,$phone,$idnumber,$bnumber,$front,$back,$stuphoto,$clubphoto){
        $user_model = new CustomModel();
        $user = $user_model->where("wx_openid",$openid)->update([
              'name'=>$name,
              'phone'=>$phone,
              'front'=>$front,
              'back'=>$back,
              'idnumber'=>$idnumber,
              'status'=>1,
              'bnumber'=>$bnumber,
              'clubphoto'=>$clubphoto,
              'stuphoto'=>$stuphoto
            ]);
        if($user){
           $msg = array(
                    "code"=> 1000,
                    "success" =>"实名认证信息上传成功"
                    );
                echo json_encode($msg);
                exit();
        }
        else{
          $msg = array(
                    "code"=> 4008,
                    "error" =>"实名认证信息上传失败"
                    );
                echo json_encode($msg);
                exit();
        }

    }
    
    
    
    /*判断用户认证状态*/
    public function userStatus($openid){
        
         $user_model = new CustomModel();
         $user = $user_model->where("wx_openid",$openid)->find();
         $joinModel = new JoinModel();
         $join = $joinModel->where('juid',$user['uid'])->find();
         if(empty($join)){
             $joinstatus = 1;
         }else{
             $joinstatus = 2;
         }
         $status = $user['status'];
         $msg = array(
                    "userstatus"=> $status,
                    "joinstatus" =>$joinstatus,
                    "success" =>"请求成功"
                    );
                echo json_encode($msg);
                exit();
        
        
    }
    
    
    /*删除用户的喜欢*/
    public function deleteLove($pid,$openid){
        
         $user_model = new CustomModel();
         $user = $user_model->where("wx_openid",$openid)->find();
         $loveModel = new LoveModel();
         $data = ['laid'=>$pid,'luid'=>$user['uid']];
         $love = $loveModel->where($data)->delete();
         if($love){
             $msg = array(
                    "code"=>1000,
                    "success" =>"喜欢删除成功"
                    );
                echo json_encode($msg);
                exit();
         }else{
             $msg = array(
                    "code"=>1004,
                    "error" =>"喜欢删除失败"
                    );
                echo json_encode($msg);
                exit();
         }
    }
    
    /**
     * 我的工作详情页
     * 
     */
    public function selectWork($mid){
        $musermodel = new MuserModel();
        $muser = $musermodel->where('mu_id',$mid)
                            ->alias("a")
                            ->join("ztx_station b",'a.mu_mid=b.mid','LEFT')
                            ->join('ztx_active c','b.mcate = c.pid')
                            ->find();
        
        echo json_encode($muser);
        exit();
    }
    
    /**
     * 是否实名认证
     */
    public function identy($openid){
        $customModel = new CustomModel();
        $custom = $customModel->where("wx_openid",$openid)->find();
        if($custom["status"]==1){
            echo 1; //审核中
            exit();
        }else if($custom["status"]==2){
            echo 2;//审核通过
            exit();
        }else{
            echo 3;//调到审核页面
            exit();
        
        }
    }
    
    
    
    public function comment($oid){
        $orderModel = new OrderModel();
        $order = $orderModel->where('oid',$oid)->find();
        
        $pimgs = $order['oimg'];
         $data['urls'] = [];
         if(is_array($pimgs)){
             foreach ($pimgs as $key => $value) {
                 $photoUrl = cmf_get_image_url($value['url']);
                 array_push($data['urls'], ['url' => $photoUrl]);
             }
         }
         
         $p["data"] = $order;
         $p["img"] = $data;
        echo json_encode($p);
        exit();
    }
    
    
    public function workcomment($muid){
        $muserModel = new MuserModel();
        $muser = $muserModel->where("mu_id",$muid)->find();
        
        $pimgs = $muser['mu_img'];
         $data['urls'] = [];
         if(is_array($pimgs)){
             foreach ($pimgs as $key => $value) {
                 $photoUrl = cmf_get_image_url($value['url']);
                 array_push($data['urls'], ['url' => $photoUrl]);
             }
         }
         
         $p["data"] = $muser;
         $p["img"] = $data;
        echo json_encode($p);
        exit();
    }
    
    
    public function info(){
      
	exec('top -b -n 1 -d 3',$out);
	$Cpu = explode('  ', $out[2]);
	$Mem = explode('  ', $out[3]);
	$Swap = explode('  ', $out[4]);
	//var_dump($Cpu,$Mem,$Swap);
	
	$cpu = str_replace(array('%us,',' '),'',$Cpu[1]);
	$mem = str_replace(array('k used,',' '),'',$Mem[2]);
	$swap = str_replace(array('k cached',' '),'',$Swap[5]);
	echo date('md H').'	'.$cpu.'	'.intval($mem/1024).'	'.intval($swap/1024).chr(10);
	sleep(10);
        
    }
    
     public function curl_https($url, $data, $header=array(), $timeout=30){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $response = curl_exec($ch);

        if($error=curl_error($ch)){
            die($error);
        }

        curl_close($ch);

        return $response;
    }
    
}
