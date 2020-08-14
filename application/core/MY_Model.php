<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    const TBL_USER_INFO = 'user_info';

    private $defaultTableName = '';

    function __construct()
    {
        parent::__construct();
    }

    public function init($tableName)
    {
        $this->defaultTableName = $tableName;
    }

    public function insert($setData)
    {
        $this->db->insert($this->defaultTableName, $setData);
        return $this->db->insert_id();
    }
}
