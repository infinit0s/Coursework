<?php
/**
 * Created by JetBrains PhpStorm.
 * 
 * Date: 20.12.12
 * Time: 23:31
 * To change this template use File | Settings | File Templates.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class libcontrollerabstract extends CI_Controller {

    protected $_superInstance;

    protected $_controllerName;

    protected $_actionName;

    protected $_userRow;

    protected $_data;

    protected $_paginationConfig;

    protected $_availableForRoles = array();

    function libcontrollerabstract() {
        parent::__construct();

        $this->_superInstance =& get_instance();

        $this->_controllerName = $this->_superInstance->router->fetch_class();

        $this->_actionName = $this->_superInstance->router->fetch_method();

        $this->_loadHelpers();

        $this->_initBasePaginationConfigForTwitterBootstrap();

        $this->_handleAuth();
        $this->_handleSimpleAcl();
        $this->_handleSessionData();
        $this->_handleViewData();

        $this->load->view('templates/header', $this->_data);
    }

    protected function _loadHelpers() {
        /**
         * load helpers
         */
        $this->load->helper('url');
        $this->load->helper('form');

        /**
         * load libs
         */
        $this->load->library('session');

        /**
         * load db models
         */
        $this->load->model('modelemployees');
    }

    protected function _handleAuth() {
        if (!in_array($this->_controllerName,array('auth')))
        {
            if (!$this->session->userdata('user') && $this->_controllerName != 'find'){
                $this->session->set_userdata(array('error' => 'You must be logged in!'));
                redirect('/auth/login');
            }
            else{
                if ($this->session->userdata('user')) {
                    $this->_userRow = $this->modelemployees->handleAuth(
                        $this->session->userdata('user')->login,
                        $this->session->userdata('user')->stringPass
                    );
                    if ($this->_userRow) {
                        $this->_userRow->stringPass = $this->session->userdata('user')->stringPass;
                        $this->session->set_userdata(array('user' => $this->_userRow));
                    }
                    else
                        $this->session->set_userdata(array('error' => modelemployees::$USER_NOT_EXISTS));
                }
            }
        }
    }

    protected function _handleSessionData() {
        if ($this->session->userdata('error')) {
            $this->_data['error'] = $this->session->userdata('error');
            $this->session->set_userdata(array('error' => null));
        }

        if ($this->session->userdata('info')) {
            $this->_data['info'] = $this->session->userdata('info');
            $this->session->set_userdata(array('info' => null));
        }
    }

    protected function _handleViewData() {
        $this->_data['user'] = $this->_userRow;
        $this->_data['controllerName'] = $this->_controllerName;
        $this->_data['roles'] = array('hr', 'super');
    }

    protected function _handleSimpleAcl() {
        if ($this->_userRow){
            $this->_data['canSee'] = false;
            if (in_array($this->_userRow->role_name, $this->_availableForRoles))
                $this->_data['canSee'] = true;
            else
                $this->session->set_userdata(array('error' => modelemployees::$PERMISSIONS));
        }
    }

    protected function _initBasePaginationConfigForTwitterBootstrap() {
        $this->_paginationConfig["per_page"] = 20;
        $this->_paginationConfig["uri_segment"] = 3;
        $this->_paginationConfig['full_tag_open'] = '<div class="pagination"><ul>';
        $this->_paginationConfig['full_tag_close'] = '</ul></div>';
        $this->_paginationConfig['prev_tag_open'] = '<li class="active">';
        $this->_paginationConfig['prev_tag_close'] = '</li>';
        $this->_paginationConfig['next_tag_open'] = '<li class="active">';
        $this->_paginationConfig['next_tag_close'] = '</li>';
        $this->_paginationConfig['first_tag_open'] = '<li class="active">';
        $this->_paginationConfig['first_tag_close'] = '</li>';
        $this->_paginationConfig['last_tag_open'] = '<li class="active">';
        $this->_paginationConfig['last_tag_close'] = '</li>';
        $this->_paginationConfig['num_tag_open'] = '<li class="active">';
        $this->_paginationConfig['num_tag_close'] = '</li>';
        $this->_paginationConfig['cur_tag_open'] = '<li class="disabled"><a>';
        $this->_paginationConfig['cur_tag_close'] = '</a></li>';
    }
}