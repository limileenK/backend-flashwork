<?php

namespace App\Controllers\UserController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\PostworkModel;

class SearchPost extends ResourceController
{
    use ResponseTrait;
 public function searchWork(){
    $keyword = $this->request->getVar('keyword');
    $modelPost = new PostworkModel();
   $data = $modelPost->like("sub_cate_name",$keyword)->orLike('aw_name',$keyword)->join('sub_cate','sub_cate.sub_cate_id = all_work.aw_sub_cate_id')->findAll();
   return $this->respond($data);
 


 }
}