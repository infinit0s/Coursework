<?php

require_once(BASEPATH.'../application/libraries/libcontrollerabstract.php');

class departments extends libcontrollerabstract {

    public function __construct() {
        $this->_availableForRoles = array('hr', 'super');

        parent::__construct();

        $this->load->model('modeldepartments');
        $this->load->library('pagination');
    }

    public function all() {
        $this->_data['result'] = $this->modeldepartments->getDepartments();
        $this->load->view("departments/all", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }

    public function change() {
        $this->_data['empNo'] = $this->uri->segment(3);
        $this->_data['formdepartments'] = $this->modeldepartments->prepareDepartmentsForForm();

        $this->load->library('form_validation');

        $this->_data['empNo'] = $this->uri->segment(3);
        $this->form_validation->set_rules('salary', '<strong>Salary</strong>', 'required|integer|greater_than[0]');

        if ($this->form_validation->run() == TRUE)
        {
            $this->modeldepartments->moveEmployee($this->input->post('emp_no'), $this->input->post('dept_no'));
            $this->session->set_userdata(array('info' => modeldepartments::$DEPARTMENT_CHANGED));

            $deptErr = $this->modeldepartments->checkDepartments();
            if ($deptErr)
                $this->seesion->set_userdata(array('error' => modeldepartments::$MANAGER_REQUIRED));

            redirect(current_url());
        }

        $this->_data = array_merge($this->_data, (array)$this->input->post());

        $this->load->view("departments/change", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }

    public function promote() {
        $this->modeldepartments->upgradeToManager($this->uri->segment(3), $this->uri->segment(4));
        $this->session->set_userdata(array('info' => modeldepartments::$PROMOTED));
        redirect(base_url('index.php/employee/all'));
    }

    public function demote() {
        $this->modeldepartments->downgradeToEmployee($this->uri->segment(3), $this->uri->segment(4));
        $this->session->set_userdata(array('info' => modeldepartments::$DEMOTED));
        $deptErr = $this->modeldepartments->checkDepartments();
        if ($deptErr)
            $this->seesion->set_userdata(array('error' => modeldepartments::$MANAGER_REQUIRED));
        redirect(base_url('index.php/employee/all'));
    }

}