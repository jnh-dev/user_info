<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
        $this->init(self::TBL_USER_INFO);
    }

}

/* End of file Join_model.php */
/* Location: ./application/models/member/Join_model.php */
