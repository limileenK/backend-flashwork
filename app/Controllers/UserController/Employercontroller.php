<?php

namespace App\Controllers\UserController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\EmploymentModel;
use App\Models\User_model\EmployerModel;

class Employercontroller extends ResourceController
{
    use ResponseTrait;

    public function getEmpData($id = null)
    {
        $emp = new EmployerModel();

        $data =  $emp
            ->where('em_username', $id)
            ->find();
        return $this->respond($data);
    }
    public function editProfileEmp($username = null)
    {
        $emp = new EmployerModel();

        $fname = $this->request->getVar('em_fname');
        $lname = $this->request->getVar('em_lname');
        $phone = $this->request->getVar('em_phone');

        $data = [
            "em_fname" =>  $fname,
            "em_lname" => $lname,
            "em_phone" => $phone
        ];
        $emp->update($username, $data);

        $response = [
            'messages' => 'success'
        ];
        return $this->respond($response);
    }
    public function getHistoryEmp($id = null){
        $employ = new EmploymentModel();

        $data =  $employ->select('*')
        ->join('package', 'package.pk_id = employment.emm_pk_id')
        ->join('all_work', 'all_work.aw_id = package.pk_aw_id')
        ->where('emm_status','Success')->where("emm_user_id",$id)
        ->findAll();
        return $this->respond($data);
    }
}
