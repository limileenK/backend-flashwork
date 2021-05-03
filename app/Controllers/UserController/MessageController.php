<?php

namespace App\Controllers\UserController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\MessageModel;


use CodeIgniter\I18n\Time;

class MessageController extends ResourceController
{
    use ResponseTrait;

    public function sendmessage()
    {
        $MessageModel = new MessageModel();
        $User_id = $this->request->getVar('User_id');
        $toUser_id = $this->request->getVar('toUser_id');
        $message = $this->request->getVar('message');
        $room = $User_id . "&" . $toUser_id;
        $user = "Username = '$User_id' AND To_Username='$toUser_id' OR Username='$toUser_id' AND To_Username = '$User_id'";

        $checkroom = $MessageModel->distinct()->select("m_room")->where($user)->find();
        if (count($checkroom) >= 1) {
            foreach ($checkroom as $row) {
                $data = [
                    "Username" => $User_id,
                    "To_Username" => $toUser_id,
                    "m_message" => $message,
                    "m_room" =>  $row['m_room']
                ];
                $MessageModel->insert($data);
                $response = [
                    'message' =>  "success"
                ];
                return $this->respond($response);
            }
        } else if (count($checkroom) != 1) {
            $data = [
                "Username" => $User_id,
                "To_Username" => $toUser_id,
                "m_message" => $message,
                "m_room" => $room
            ];
            $MessageModel->insert($data);
            $response = [
                'message' =>  'success'
            ];
            return $this->respond($response);
        }
    }
    public function showmessagebyid($id = null)
    {
        $MessageModel = new MessageModel();
        $data = $MessageModel->select("m_message , m_time , Username , To_Username")->where('m_room', $id)->findAll();
        return $this->respond($data);
    }
    public function showlistmessage($id = null)
    {
        $MessageModel = new MessageModel();
        $data1 = $MessageModel->distinct()->select("To_Username,std_image,em_image,m_room")
            ->join('student', 'student.std_id = message.To_Username', 'LEFT')
            ->join('employer', 'employer.em_username = message.To_Username', 'LEFT')
            ->where('Username', $id)
            ->findAll();

        return $this->respond($data1);
    }
}
