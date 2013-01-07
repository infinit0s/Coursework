<?php
require_once(BASEPATH.'../application/libraries/libcontrollerabstract.php');

class employee extends libcontrollerabstract {

    public function Employee() {
        $this->_availableForRoles = array('standard', 'hr', 'super');

        parent::__construct();

        $this->load->library('pagination');
    }

    public function all() {
        $this->_paginationConfig["base_url"] = base_url() . "index.php/employee/all";

        $this->_data['canSeeComponent'] = in_array($this->_userRow->role_name, array('hr', 'super'));

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

        $this->load->view("employee/all", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }

    public function remove() {
        $this->load->model('modeltitles');
        $this->load->model('modelsalaries');
        $this->load->model('modeldepartments');

        $this->modeltitles->removeEmployee($this->uri->segment(3));
        $this->modelsalaries->removeEmployee($this->uri->segment(3));
        $this->modeldepartments->removeEmployee($this->uri->segment(3));

        $deptErr = $this->modeldepartments->checkDepartments();
        if ($deptErr){
            $this->session->set_userdata(array('error' => modeldepartments::$MANAGER_REQUIRED.implode(',', $deptErr)));
        }
        $this->session->set_userdata(array('info' => modelemployees::$User_REMOVED));
        redirect(base_url('index.php/employee/all'));
    }

    public function details() {
        $this->load->model('modeltitles');
        $this->load->model('modelsalaries');
        $this->load->model('modeldepartments');

        $this->_data['data'] = $this->modelemployees->fetchDetails($this->uri->segment(3));
        $this->_data['salaries'] = $this->modelsalaries->getSalariesByEmpNo($this->uri->segment(3));
        $this->_data['titles'] = $this->modeltitles->getTitlesByEmpNo($this->uri->segment(3));
        $this->_data['deDepartments'] = $this->modeldepartments->getDeDepartmentsByEmpNo($this->uri->segment(3));
        $this->_data['dmDepartments'] = $this->modeldepartments->getDmDepartmentsByEmpNo($this->uri->segment(3));

        $this->load->view('employee/details', $this->_data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model('modelroles');
        $this->load->model('modeldepartments');
        $this->_data['formroles'] = $this->modelroles->prepareRolesForForm();
        $this->_data['formdepartments'] = $this->modeldepartments->prepareDepartmentsForForm();

        $this->form_validation->set_rules('birthdate', '<strong>Birthdate</strong>', 'required');
        $this->form_validation->set_rules('firstname', '<strong>Firstname</strong>', 'required|max_length[14]');
        $this->form_validation->set_rules('lastname', '<strong>Lastname</strong>', 'required|max_length[16]');
        $this->form_validation->set_rules('title', '<strong>Title</strong>', 'required|max_length[50]');
        $this->form_validation->set_rules('login', '<strong>Login</strong>', 'required|is_unique[employees.login]|max_length[64]');
        $this->form_validation->set_rules('password', '<strong>Password</strong>', 'required|max_length[40]');
        //$this->form_validation->set_rules('', '', 'required');

        if ($this->form_validation->run() == TRUE)
        {
            /*$birth, $first, $last, $gender, $title, $role, $dept_no, $login, $pass*/
            if ($this->modelemployees->addEmployee(
                $this->input->post('birthdate'),
                $this->input->post('firstname'),
                $this->input->post('lastname'),
                $this->input->post('gender'),
                $this->input->post('title'),
                $this->input->post('role'),
                $this->input->post('dept_no'),
                $this->input->post('login'),
                $this->input->post('password')
            )) {
                $this->session->set_userdata(array('info' => modelemployees::$USER_ADDED));
                redirect(current_url());
                }
            else
                $this->session->set_userdata(array('error' => modelemployees::$ERROR));
        }
        //$this->modelemployees->addEmployee();
        $this->_data = array_merge($this->_data, (array)$this->input->post());
        //var_dump($this->input->post());

        $this->load->view('employee/add', $this->_data);
        $this->load->view('templates/footer');
    }

    public function editrole() {
        $this->load->library('form_validation');
        $this->load->model('modelroles');
        $this->_data['empNo'] = $this->uri->segment(3);
        $this->_data['formroles'] = $this->modelroles->prepareRolesForForm();

        $this->form_validation->set_rules('role_id', '<strong>Role_id</strong>', 'integer');

        if ($this->form_validation->run() == TRUE)
        {
            $this->modelemployees->updateRole($this->input->post('emp_no'), $this->input->post('role_id'));
            $this->session->set_userdata(array('info' => modelemployees::$USER_ROLE_UPDATED));


            redirect(current_url());
        }


        $this->_data = array_merge($this->_data, (array)$this->input->post());

        $this->load->view("employee/editrole", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }
}