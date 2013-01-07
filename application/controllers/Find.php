<?php

require_once(BASEPATH.'../application/libraries/libcontrollerabstract.php');

class find extends libcontrollerabstract {
    public function __construct() {
        $this->_availableForRoles = array('standard', 'hr', 'super');

        parent::__construct();

        $this->load->library('pagination');
    }

    public function findemp() {
        $this->_paginationConfig["base_url"] = base_url() . "index.php/find/findemp";
        $this->_data['canSeeComponent'] = $this->_userRow && in_array($this->_userRow->role_name, array('hr', 'super'));


        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->_data["results"] = $this->modelemployees->fetchEmployees($this->_paginationConfig["per_page"], $page,
            (bool)$this->input->get('empno') ? $this->input->get('empno') : null,
            (bool)$this->input->get('firstname') ? $this->input->get('firstname') : null,
            (bool)$this->input->get('lastname') ? $this->input->get('lastname') : null,
            (bool)$this->input->get('rolename') ? $this->input->get('rolename') : null,
            (bool)$this->input->get('title') ? $this->input->get('title') : null,
            (bool)$this->input->get('dept') ? $this->input->get('dept') : null
        );

        $this->_paginationConfig["total_rows"] = $this->modelemployees->fetchCurrentEmployeesCount(
            (bool)$this->input->get('empno') ? $this->input->get('empno') : null,
            (bool)$this->input->get('firstname') ? $this->input->get('firstname') : null,
            (bool)$this->input->get('lastname') ? $this->input->get('lastname') : null,
            (bool)$this->input->get('rolename') ? $this->input->get('rolename') : null,
            (bool)$this->input->get('title') ? $this->input->get('title') : null,
            (bool)$this->input->get('dept') ? $this->input->get('dept') : null
        );
        $this->pagination->initialize($this->_paginationConfig);


        $this->_data["links"] = $this->pagination->create_links();

        $this->load->view("find/findemp", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }
}