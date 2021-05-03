<?php

namespace App\Controllers\WorkController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\PostworkModel;
use App\Models\Work_model\Work_img;
use App\Models\Work_model\PackageModel;
use App\Models\Admin_model\Subcategory;


class ShowWork extends ResourceController
{
    use ResponseTrait;
    public function ShowAllWork()
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel
            ->join('package', 'package.pk_aw_id = all_work.aw_id')
            ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->findAll();
        return $this->respond($data);
    }



    public function ShowWorkCount() //หน้าhome
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel

            ->select('aw_id,aw_name,aw_detail,pk_price,pk_time_period,aw_sub_cate_id,std_fname,std_lname,w_img_name,')
            ->selectCount('emm_std_id')
            ->join('package', 'package.pk_aw_id = all_work.aw_id')
            ->join('employment', 'employment.emm_std_id = all_work.aw_std_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->where('emm_status', 'success')->groupBy('emm_std_id')
            ->orderBy('emm_std_id', 'DESC')
            ->where('aw_status', 'Approve')->groupBy('aw_id')

            ->findAll();
        return $this->respond($data);
    }

    public function getDetailPost($id = null) //หน้าโชว์ข้อมูล
    {
        
            $PostworkModel = new PostworkModel();
            $Work_img = new Work_img();
            $PackageModel = new PackageModel();
    
            $workbyid = $PostworkModel->where('aw_id', $id)->first();
            $packagebyid = $PackageModel->select('pk_id,pk_name,pk_detail,pk_price,pk_time_period')->where('pk_aw_id', $id)->findAll();
            $imgbyid = $Work_img
                ->select('w_img_name')
                ->where('w_aw_id', $id)
                ->findAll();
            $data = [
                $workbyid,
                $packagebyid,
                $imgbyid
            ];
            return $this->respond($data);
        
    }
    public function ShowPIC($id = null) //หน้าโชว์ข้อมูล
    {
        $WorkimgModel = new Work_img();
        $img = $WorkimgModel
            ->select('*')
            ->where('w_aw_id', $id)->orderBy('w_aw_id')
            ->findAll();
        return $this->respond($img);
    }

    public function showWorkbysubcate($id = null)
    {
        $model = new Subcategory();
        $data = $model
            ->select('*')
            ->join('all_work', 'all_work.aw_sub_cate_id = sub_cate.sub_cate_id')
            ->join('work_img', 'all_work.aw_id = work_img.w_aw_id')
            ->join('package', ' all_work.aw_id = package.pk_aw_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->where('sub_cate.sub_cate_id', $id)
            ->where('all_work.aw_status',  'Approve')
            ->groupBy('all_work.aw_id')
            ->findAll();
        return $this->respond($data);
    }
}
