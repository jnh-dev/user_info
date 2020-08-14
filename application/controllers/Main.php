<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index()
    {
        if ($this->session->userdata('login_state') == true) {
            echo $this->session->userdata('id') . ' 접속중';
            $this->load->view('logout_view');
        } else {
            $this->load->view('Main_view');
        }

        $data['id'] = $this->session->userdata('id');
        $this->load->view('member/info_btn', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('/main'), 'refresh');
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
