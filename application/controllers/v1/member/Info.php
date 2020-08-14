<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends MY_Controller {
    const VIEW_PATH = 'member/' . __CLASS__ . '_view';

    function __construct()
    {
        parent::__construct();
        $this->load->model('member/Login_model', 'loginModel');
    }

    public function index()
    {
        $oPost = (object) $this->input->post(null, true);

        $oWhere = (object) [
            'id'        => $oPost->id,
        ];

        $data['userInfo'] = (object) $this->loginModel->getLoginInfo($oWhere);

        $this->load->view(self::VIEW_PATH, $data);
    }
}

/* End of file info.php */
/* Location: ./application/controllers/v1/member/info.php */
