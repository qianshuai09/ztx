<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2018/8/12
 * Time: 16:06
 */

namespace app\admin\controller;
use app\portal\model\BannerModel;

use cmf\controller\AdminBaseController;

class BannerController extends AdminBaseController
{


    public function index(){
        
    }
    public function edit(){
        $bannerModel = new BannerModel();
        $banner = $bannerModel->where('bid',1)->find();
        $this->assign('banner',$banner);
        $this->assign('img',$banner['bimage']);
        return $this->fetch();
    }

    public function editPost(){
        $data = $this->request->param();

        if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
            $data['image'] = [];
            foreach ($data['photo_urls'] as $key => $url) {
                $photoUrl = cmf_asset_relative_url($url);
                array_push($data['image'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
            }
        }

        $image = json_encode($data['image']);

        $param = [
            'bimage'=>$image
            ];
        $bannerModel = new BannerModel();
        $banner = $bannerModel ->where('bid',$data['bid'])->update($param);
        if($banner){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }

    }
}