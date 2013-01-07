<?php
/**
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 21.12.12
 * Time: 04:16
 * To change this template use File | Settings | File Templates.
 */

class modelroles extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function fetchAll(){
        return $this->db->get('roles')->result();
    }

    public function prepareRolesForForm() {
        $result = $this->db->get('roles');

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[$row->id] = $row->name;
            return $data;
        }
        return false;
    }
}