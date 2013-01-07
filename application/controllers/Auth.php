<?php
/**
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 20.12.12
 * Time: 23:36
 * To change this template use File | Settings | File Templates.
 */
require_once(BASEPATH.'../application/libraries/libcontrollerabstract.php');

class auth extends libcontrollerabstract {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('login', 'Login', 'required|trim|xss_clean');
        $this->form_validation->set_rules('pass', 'Password', 'required|trim|xss_clean|min_length[3]|max_length[12]');

        //$this->session->set_userdata(array('error' => $this->input->post('login')));

        if (!$this->form_validation->run())
            $this->load->view('auth/login');
        else{
            $this->_userRow = $this->modelemployees->handleAuth(
                $this->input->post('login'),
                $this->input->post('pass')
            );

            if ($this->_userRow) {
                $this->_userRow->stringPass = $this->input->post('pass');
                $this->session->set_userdata(array('user' => $this->_userRow));
                $this->session->set_userdata(array('info' => modelemployees::$USER_LOGGED_IN));
                redirect(base_url('index.php/employee/all/'));
            }
            else {
                $this->session->set_userdata(array('error' => modelemployees::$USER_NOT_EXISTS));
                $this->load->view('auth/login');
            }

        }

        $this->load->view('templates/footer');
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->session->set_userdata(array('info' => modelemployees::$USER_LOGGED_OUT));
        redirect('/auth/login/');
    }
}