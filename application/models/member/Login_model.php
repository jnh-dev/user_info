<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
        $this->init(self::TBL_USER_INFO);
    }

    public function getLoginInfo($oWhere)
    {
        if ( ! empty($oWhere->existingId) == true) {
            $this->db->where('userInfo.password', $oWhere->password);
        }

        $queryResult = $this->db
            ->select('
                userInfo.id AS id,
                userInfo.password AS password,
                userInfo.user_name AS userName,
            ')
            ->where('userInfo.id', $oWhere->id)
        ->get(self::TBL_USER_INFO . ' AS userInfo');

        return $queryResult->row();
    }
}

/* End of file Login_model.php */
/* Location: ./application/models/member/Login_model.php */
