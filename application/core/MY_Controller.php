<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    protected function loginCheck($viewPath)
    {
        if ($this->session->userdata('login_state') == true) {
            echo "
                <script>
                    alert('잘못된 접근입니다');
                </script>
            ";
            $this->load->view('logout_view');
            redirect(base_url('/main'), 'refresh');
        } else {
            $this->load->view($viewPath);
        }
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
