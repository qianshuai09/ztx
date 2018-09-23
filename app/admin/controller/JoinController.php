<?php


namespace app\admin\controller;

use app\portal\model\JoinModel;
use cmf\controller\AdminBaseController;

class JoinController extends AdminBaseController
{
    public function index(){
      $joinModel = new JoinModel();
      $join = $joinModel->paginate();
      $this->assign("join",$join);
      $this->assign("page",$join->render());
      return $this->fetch();
    }
    
    
    public function delete(){
         $product_model = new JoinModel();
        $data            = $this->request->param();

        $result = $product_model->where(['jid'=>$data['id']])->delete();

        if ($result) {
            
            $this->success(lang('DELETE_SUCCESS'));
        } else {
            $this->error(lang('DELETE_FAILED'));
        }
    }
}
