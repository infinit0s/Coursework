<?php
/**
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 06.12.12
 * Time: 01:05
 * To change this template use File | Settings | File Templates.
 */
require_once(BASEPATH.'../application/libraries/libcontrollerabstract.php');

class index extends libcontrollerabstract
{
    function index(){

        //if i remove this parent::__construct(); the error is gone
        parent::__construct();
        /*or
        parent::__construct();
        */
        //var_dump();
    }

    public function test($page = 'test')
    {

        if ( ! file_exists('application/views/index/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        //var_dump($this->_controllerName);

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('index/'.$page, $data);
        $this->load->view('templates/footer', $data);

    }
}
