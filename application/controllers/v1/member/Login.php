<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    const VIEW_PATH = 'member/' . __CLASS__ . '_view';
    const MODEL_PATH = 'member/' . __CLASS__ . '_model';

    function __construct()
    {
        parent::__construct();
        $this->load->model(self::MODEL_PATH, 'loginModel');
    }

    public function index()
    {
        $this->loginCheck(self::VIEW_PATH);
    }

    public function login()
    {
        $oPost = (object) $this->input->post(null, true);

        $this->validationCheck($oPost);

        $salt = '$1$4$';
        $oWhere = (object) [
            'id'        => $oPost->id,
            'password'  => crypt($oPost->password, $salt),
        ];

        $this->db = $this->load->database('default', true);
        $userInfo = $this->loginModel->getLoginInfo($oWhere);

        if (empty($userInfo->id)) {
            echo '해당하는 아이디는 존재하지 않습니다.';
            return false;
        } else {
            $oWhere->existingId = true;
            $userInfo = (object) $this->loginModel->getLoginInfo($oWhere);

            if ( ! empty($userInfo->id)) {
                $accessToken = $this->addAccessToken($userInfo);

                $sessionData = [
                    'id'            => $userInfo->id,
                    'userName'      => $userInfo->userName,
                    'login_time'    => date('Y/m/d H:i:s.u'),
                    'login_state'   => true
                ];

                $this->session->set_userdata($sessionData);
                redirect(base_url('/main'), 'refresh');
            } else {
                echo '패스워드가 일치하지 않습니다.';
                return false;
            }
        }
    }

    private function validationCheck($oPost)
    {
        if (empty($oPost->id)) {
            echo '<script>
                    alert("아이디를 입력해주세요.");
                    location.href = "../login";
            </script>';
        }

        $checkEmail = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $oPost->id);
        if($checkEmail == false) {
            echo '<script>
                    alert("이메일 형식이 아닙니다.");
                    location.href = "../login";
            </script>';
        }

        if (empty($oPost->password)) {
            echo '<script>
                    alert("비밀번호를 입력해주세요.");
                    location.href = "../login";
            </script>';
        }
    }

    private function addAccessToken($userInfo)
    {
        $url = 'dev.bithumb.co.kr/AddToken/accessToken?id=1';

        $postData = [
            'id'        => '1'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);

        $result = json_decode($data);
        print_r($result);
        exit;
        //return $result;
    }

}

/* End of file login.php */
/* Location: ./application/controllers/v1/member/login.php */
