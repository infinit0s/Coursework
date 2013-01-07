<?php

require_once(BASEPATH.'../application/libraries/libcontrollerabstract.php');

class salaries extends libcontrollerabstract {

    public function __construct() {
        $this->_availableForRoles = array('hr', 'super');

        parent::__construct();

        $this->load->model('modelsalaries');
        $this->load->library('pagination');
    }

    public function all() {
        $this->_paginationConfig["base_url"] = base_url() . "index.php/salaries/all";

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($this->_data['canSee']) {
            $this->_data["results"] = $this->modelsalaries->getSalaries($this->_paginationConfig["per_page"], $page,
                (bool)$this->input->get('empno') ? $this->input->get('empno') : null,
                (bool)$this->input->get('firstname') ? $this->input->get('firstname') : null,
                (bool)$this->input->get('lastname') ? $this->input->get('lastname') : null);

            $this->_paginationConfig["total_rows"] = $this->modelsalaries->fetchCount(
                (bool)$this->input->get('empno') ? $this->input->get('empno') : null,
                (bool)$this->input->get('firstname') ? $this->input->get('firstname') : null,
                (bool)$this->input->get('lastname') ? $this->input->get('lastname') : null
            );
            $this->pagination->initialize($this->_paginationConfig);

            $this->_data["links"] = $this->pagination->create_links();
        }
        $this->load->view("salaries/all", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }

    public function increase(){
        $this->load->library('form_validation');

        if ($this->_userRow->role_name != 'super'){
            $this->data['canSee'] = false;
            $this->session->set_userdata(array('error' => modelemployees::$PERMISSIONS));
        } else {
            $this->form_validation->set_rules('percent', '<strong>Percent</strong>', 'required|integer|greater_than[0]');

            if ($this->form_validation->run() == TRUE)
            {
                    $this->modelsalaries->recalculateSalaries($this->input->post('percent'));
                    $this->session->set_userdata(array('info' => modelsalaries::$_SALARIES_INCREASED));
                    redirect(current_url());
            }

            $this->_data = array_merge($this->_data, (array)$this->input->post());
        }

        $this->load->view("salaries/increase", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }

    public function edit(){
        $this->load->library('form_validation');

        $this->_data['empNo'] = $this->uri->segment(3);
            $this->form_validation->set_rules('salary', '<strong>Salary</strong>', 'required|integer|greater_than[0]');

            if ($this->form_validation->run() == TRUE)
            {
                $this->modelsalaries->updateSalary($this->input->post('emp_no'), $this->input->post('salary'));
                $this->session->set_userdata(array('info' => modelsalaries::$_SALARIES_INCREASED));
                redirect(current_url());
            }

            $this->_data = array_merge($this->_data, (array)$this->input->post());


        $this->load->view("salaries/edit", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }
}