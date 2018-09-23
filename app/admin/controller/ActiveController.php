<?php

namespace app\admin\controller;
use app\admin\model\ActiveModel;
use app\admin\model\StationModel;

use cmf\controller\AdminBaseController;

class ActiveController extends AdminBaseController
{
    
    public function index(){
        
       $activeModel = new ActiveModel();
       $actvie = $activeModel->where('pcategory',1)->paginate(10);
       $this->assign("active",$actvie);
       $this->assign('page',$actvie->render());
       return $this->fetch();
    }
    
    public function edit(){
        $id = $this->request->param('id');
        $activeModel = new ActiveModel();
        $actvie = $activeModel->where('pid',$id)->find();
        $this->assign('result',$actvie);
        return $this->fetch();
        
    }
    
    public function editPost(){
          $data           = $this->request->param();
        $slidePostModel = new ActiveModel();
        $result         = $slidePostModel->save($data, ['pid' => $data['pid']]);
        if ($result === false) {
            $this->error($slidePostModel->getError());
        }
        $this->success("保存成功！", url("active/index"));
    }
    
    public function job(){
        
       $activeModel = new ActiveModel();
       $actvie = $activeModel->where('pcategory',2)->paginate(10);
       $this->assign("active",$actvie);
       $this->assign('page',$actvie->render());
       return $this->fetch();
    }
    
    public function AddJob(){
       return  $this->fetch();
    }
    
    public function editJob(){
        $id = $this->request->param('id');
        $activeModel = new ActiveModel();
        $actvie = $activeModel->where('pid',$id)->find();
        $this->assign('result',$actvie);
        return $this->fetch();
    }
    
    public function editJobPost(){
         $data           = $this->request->param();
        $slidePostModel = new ActiveModel();
        $result         = $slidePostModel->save($data, ['pid' => $data['pid']]);
        if ($result === false) {
            $this->error($slidePostModel->getError());
        }
        $this->success("保存成功！", url("active/job"));
    }
    
    public function active(){
        
       $activeModel = new ActiveModel();
       $actvie = $activeModel->where('pcategory',3)->paginate(10);
       $this->assign("active",$actvie);
       $this->assign('page',$actvie->render());
       return $this->fetch();
    }
    
    public function add(){
        return $this->fetch();
    }
    
    public function addPost(){
         if ($this->request->isPost()) {
            $data = $this->request->param();
            $productModel = new ActiveModel();
        
               $productModel->data([
                    'pimg' => $data['pimg'],
                    'pname'=>$data['pname'],
                    'ptitle' => $data['ptitle'],
                    'pprice' => $data['pprice'],
                    'zanzhu' => $data['zanzhu'],
                    'starttime' => $data['starttime'],
                    'endtime' => $data['endtime'],
                    'pdetail'=>$data['pdetail'],
                    'pcategory'=>1,
                    'create_time'=>date('Y-m-d h:i:sa')
                ]);
                $result = $productModel->save();
                if($result===false){
                    $this->error($productModel->getError());
                }else{
                    $this->success("添加成功！",url('active/index'));
                }
            }
    }
    
    public function addactive(){
          return $this->fetch();
    }
    
    public function addactivePost(){
         if ($this->request->isPost()) {
            $data = $this->request->param();
            $productModel = new ActiveModel();
           if (!empty($data['photo_urls'])) {
                $data['purl'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['purl'], ["url" => $photoUrl]);
                }
                
               //将二维数组转换成字符串对象存入数据库
               $pimges =  json_encode($data['purl']); 
                //从数据库中拿到字符串对象还原的函数是 unserialize()
               $productModel->data([
                    'pimg' => $data['pimg'],
                    'pname'=>$data['pname'],
                    'ptitle' => $data['ptitle'],
                    'atime' => $data['atime'],
                    'alocation' => $data['alocation'],
                    'abeizhu' => $data['abeizhu'],
                    'pextend' => $pimges,
                    'pcategory'=>3,
                    'create_time'=>date('Y-m-d h:i:sa')
                ]);
                $result = $productModel->save();
                if($result===false){
                    $this->error($productModel->getError());
                }else{
                    $this->success("添加成功！",url('active/active'));
                }
            }
        }
    }
    
    
    public function editActivePost(){
        
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $productModel = new ActiveModel();
           if (!empty($data['photo_urls'])) {
                $data['purl'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['purl'], ["url" => $photoUrl]);
                }
                
               //将二维数组转换成字符串对象存入数据库
               $pimges =  json_encode($data['purl']); 
                //从数据库中拿到字符串对象还原的函数是 unserialize()
               $datas = [
                    'pimg' => $data['pimg'],
                    'pname'=>$data['pname'],
                    'ptitle' => $data['ptitle'],
                    'atime' => $data['atime'],
                    'alocation' => $data['alocation'],
                    'abeizhu' => $data['abeizhu'],
                    'pextend' => $pimges,
                    'pcategory'=>3,
                ];
                $result = $productModel->save($datas, ['pid' => $data['pid']]);
                if($result===false){
                    $this->error($productModel->getError());
                }else{
                    $this->success("编辑成功！",url('active/active'));
                }
            }
        }
    }
    
     /*
     * 产品删除
     *
     */
    public function delete(){
        
        $product_model = new ActiveModel();
        $data            = $this->request->param();

        $result = $product_model->where(['pid'=>$data['id']])->delete();

        if ($result) {
            $this->success(lang('DELETE_SUCCESS'));
        } else {
            $this->error(lang('DELETE_FAILED'));
        }
    }
    
    
    public function activeedit(){
         $id = $this->request->param('id', 0, 'intval');
        $productModel = new ActiveModel();
        $product = $productModel->where('pid',$id)->find();
        $pimgs = $product['pextend'];
        
        $this->assign('photo',$pimgs);
        $this->assign('product',$product);
        return $this->fetch();
    }
    
    public function Manager(){
       $stationModel = new StationModel;
       $station = $stationModel
                  ->alias("a")
                  ->join('ztx_active b','a.mcate = b.pid')
                  ->paginate(10);
       $this->assign('page',$station->render());
       $this->assign('station',$station);
       
       
       return $this->fetch();
    }
    
    
    public function AddStation(){
        
        $activeModel = new ActiveModel();
        $active = $activeModel->where('pcategory',2)->field('pid,pname')->select();
        $this->assign("active",$active);
        return $this->fetch();
    }
 
    public function AddStationPost(){
          $data           = $this->request->param();

        $categoryModel = new StationModel();
        $result         = $categoryModel->save($data);
        if ($result === false) {
            $this->error($categoryModel->getError());
        }
        $this->success("添加成功！", url("active/Manager"));
    }   
    
    
    public function addJobPost(){
          $data           = $this->request->param();

        $categoryModel = new ActiveModel();
        $result         = $categoryModel->save($data);
        if ($result === false) {
            $this->error($categoryModel->getError());
        }
        $this->success("添加成功！", url("active/Job"));

    }
    
    public function deleteStation(){
        $product_model = new stationModel();
        $data            = $this->request->param();

        $result = $product_model->where(['mid'=>$data['id']])->delete();

        if ($result) {
            $this->success(lang('DELETE_SUCCESS'));
        } else {
            $this->error(lang('DELETE_FAILED'));
        }
    }
    
    public function editstation(){
        
         $id             = $this->request->param('id');
        $slidePostModel = new stationModel();
        $activeModel = new ActiveModel();
        $active = $activeModel->where('pcategory',2)->field('pid,pname')->select();
        
        $result         = $slidePostModel->where('mid', $id)->find();
        $this->assign('result', $result);
        $this->assign('category',$active);
        return $this->fetch();
    }
    
    
    public function EditStationPost(){
        $data           = $this->request->param();
        $slidePostModel = new stationModel();
        $result         = $slidePostModel->save($data, ['mid' => $data['mid']]);
        if ($result === false) {
            $this->error($slidePostModel->getError());
        }
        $this->success("保存成功！", url("active/Manager"));
    }
}
 