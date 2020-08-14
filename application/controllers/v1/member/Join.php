<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join extends MY_Controller {

    const VIEW_PATH = 'member/' . __CLASS__ . '_view';
    const MODEL_PATH = 'member/' . __CLASS__ . '_model';

    function __construct()
    {
        parent::__construct();
        $this->load->model(self::MODEL_PATH, 'joinModel');
        $this->load->model('member/Login_model', 'loginModel');
    }

    public function index()
    {
        $this->loginCheck(self::VIEW_PATH);
    }

    private function validationCheck($oPost)
    {
        //이메일 형식 체크
        $checkEmail = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $oPost->id);
        if($checkEmail == false) {
            $result = [
                'resultMsg'  => '잘못된 이메일 형십입니다.',
                'result'     => false,
            ];

            return $result;
        }

        //비밀번호 체크
        $checkPassword = preg_match("/^.*(?=^.{12,30}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/", $oPost->password);
        if ($checkPassword == false) {
            $result = [
                'resultMsg'  => '비밀번호는 영문, 숫자, 특수문자 조합으로 12자리 이상 가능합니다.',
                'result'     => false,
            ];

            return $result;
        }

        //비밀번호 저장시 단방향 해시처리
        $salt = '$1$4$';
        $oPost->password = crypt($oPost->password, $salt);

        //이름 체크
        $checkUserName = preg_match("/^[\x{ac00}-\x{d7af}]{2,5}$/u", $oPost->userName);
        if ($checkUserName == false) {
            $result = [
                'resultMsg'  => '이름이 옳바르지 않습니다.',
                'result'     => false,
            ];

            return $result;
        }

        //존재하는 아이디 체크
        $oWhere = (object) [
            'id'    => $oPost->id
        ];
        $userId = (object) $this->loginModel->getLoginInfo($oWhere);
        if ( ! empty($userId->id)) {
            $result = [
                'resultMsg'  => '이미 존재하는 아이디 입니다',
                'result'     => false,
            ];

            return $result;
        }

        $result = [
            'resultMsg'  => "{$oPost->userName}님 아이디 {$oPost->id}로 회원 가입 완료 되었습니다.",
            'result'     => true,
        ];

        return $result;
    }

    public function add()
    {
        $oPost = (object) $this->input->post(null, true);

        $validation = $this->validationCheck($oPost);
        if ($validation['result'] != true) {
            echo json_encode($validation);
            return false;
        }

        $setData = [
            'id'        => $oPost->id,
            'password'  => $oPost->password,
            'user_name' => $oPost->userName
        ];

        $this->db = $this->load->database('default', true);
        $result = $this->joinModel->insert($setData);

        if ($result > 0) {
            echo json_encode($validation);
        }
    }
}

/* End of file join.php */
/* Location: ./application/controllers/v1/member/join.php */
