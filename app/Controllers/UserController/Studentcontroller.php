<?php

namespace App\Controllers\UserController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\StudentModel;
use App\Models\Work_model\EmploymentModel;

class Studentcontroller extends ResourceController
{
    use ResponseTrait;

    public function getStudentData($id = null){
        $student = new StudentModel();

        $data =  $student->select('*')
        ->join('major', 'major.major_id = student.std_marjor_id')
        ->join('faculty', 'faculty.fac_id = major.major_id')
        ->where('std_id',$id)
        ->findAll();
        return $this->respond($data);
    }
    public function editProfileFree($id = null){
        $student = new StudentModel();

        $fname = $this->request->getVar('std_fname');
        $lname = $this->request->getVar('std_lname');
        $phone = $this->request->getVar('std_phone');
        
        $data = [
            "std_fname" =>  $fname,
            "std_lname" => $lname,
            "std_phone" => $phone
        ];
        $student->update($id, $data);

        $response = [
            'messages' => 'success'
        ];
        return $this->respond($response);

    }
    public function getHistoryFree($id = null){
        $employ = new EmploymentModel();

        $data =  $employ->select('*')
        ->join('package', 'package.pk_id = employment.emm_pk_id')
        ->join('all_work', 'all_work.aw_id = package.pk_aw_id')
        ->where('emm_status','Success')->where("emm_std_id",$id)
        ->findAll();
        return $this->respond($data);
    }
}