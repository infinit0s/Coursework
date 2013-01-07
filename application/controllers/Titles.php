<?php

require_once(BASEPATH.'../application/libraries/libcontrollerabstract.php');

class titles extends libcontrollerabstract {
    public function titles() {
        $this->_availableForRoles = array('hr', 'super');

        parent::__construct();

        $this->load->model('modeltitles');
        $this->load->library('pagination');
    }

    public function all() {
        $this->_paginationConfig["base_url"] = base_url() . "index.php/titles/all";

        $this->_data['canSeeComponent'] = in_array($this->_userRow->role_name, array('hr', 'super'));

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        if ($this->_data['canSee']) {
            $this->_data["results"] = $this->modeltitles->getTitles($this->_paginationConfig["per_page"], $page,
                (bool)$this->input->get('empno') ? $this->input->get('empno') : null,
                (bool)$this->input->get('firstname') ? $this->input->get('firstname') : null,
                (bool)$this->input->get('lastname') ? $this->input->get('lastname') : null,
                (bool)$this->input->get('title') ? $this->input->get('title') : null
            );

            $this->_paginationConfig["total_rows"] = $this->modeltitles->fetchCount(
                (bool)$this->input->get('empno') ? $this->input->get('empno') : null,
                (bool)$this->input->get('firstname') ? $this->input->get('firstname') : null,
                (bool)$this->input->get('lastname') ? $this->input->get('lastname') : null,
                (bool)$this->input->get('title') ? $this->input->get('title') : null
            );
            $this->pagination->initialize($this->_paginationConfig);

            $this->_data["links"] = $this->pagination->create_links();
        }
        $this->load->view("titles/all", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }

    public function edit(){
        $this->load->library('form_validation');

        $this->_data['empNo'] = $this->uri->segment(3);
        $this->form_validation->set_rules('title', '<strong>Title</strong>', 'required|max_length[50]');

        if ($this->form_validation->run() == TRUE)
        {
            $this->modeltitles->updateTitle($this->input->post('emp_no'), $this->input->post('title'));
            $this->session->set_userdata(array('info' => modeltitles::$TITLE_UPDATED));
            redirect(current_url());
        }

        $this->_data = array_merge($this->_data, (array)$this->input->post());


        $this->load->view("titles/edit", $this->_data);
        $this->load->view('templates/footer', $this->_data);
    }
}