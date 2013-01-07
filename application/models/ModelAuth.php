<?php
/**
 * -----------------------------
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 23.12.12
 * Time: 11:40
 * -----------------------------
 */

class modelauth extends CI_Model {

    private static $SALT = 'o)f7LLUe<8o';

    public function __construct(){
        parent::__construct();

        $this->load->library('session');
    }

    public function handleAuth($user, $pass) {

        $this->db->select('e.*');
        $this->db->from('employees e');
        $this->db->where('e.login', $user);
        $this->db->where('e.pass', sha1($pass.self::$SALT));

        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

}