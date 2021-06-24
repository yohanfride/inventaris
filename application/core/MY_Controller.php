<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        /*
         * START FirePHP Initialization
         *
        $this->load->config('fireignition');
        if ($this->config->item('fireignition_enabled'))
        {
            if (floor(phpversion()) < 5)
            {
                log_message('error', 'PHP 5 is required to run fireignition');
            } else {
                $this->load->library('firephp');
            }
        }
        else 
        {
            $this->load->library('firephp_fake');
            $this->firephp =& $this->firephp_fake;
        }

        $this->firephp->registerErrorHandler($throwErrorExceptions=false);
        $this->firephp->registerExceptionHandler();
        $this->firephp->registerAssertionHandler($convertAssertionErrorsToExceptions=true,$throwAssertionExceptions=false);
        /* END FirePHP Initialization  */

        if (in_array($this->uri->segment(3), array('baru', 'progress', 'aktif', 'cancel', 'pelanggan', 'calon', 'pending')))
        {
            $this->session->set_userdata('current', uri_string());
        }
        
        if ($this->session->userdata('uri') !== $this->uri->segment(1))
        {
            $this->_unset_all();
            $this->session->set_userdata('uri', $this->uri->segment(1));
        }

        if ($this->is_logged_in() === FALSE)
        {
            //redirect('admin/login');
        }

        //$this->output->enable_profiler(TRUE);

    }

    public function is_logged_in()
    {
        if ($this->session->userdata('login'))
            return TRUE;
        else
            return FALSE;
    }

    public function print_pre($obj)
    {
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }

    public function forbidden($role)
    {
        if ($this->session->userdata['login']['type'] > $role)
        {
            $message_403 = "Anda tidak memiliki akses untuk membuka alamat ini.";
            show_error($message_403, 403, "Forbidden Access!!!");
        }
    }

    public function set_filter()
    {
        //Cek session untuk pencarian
        if (isset($_POST['filter']))
            $this->session->set_userdata('filter', $_POST['filter']);

        $data['filter'] = isset($this->session->userdata['filter']) ? $this->session->userdata['filter'] : NULL;
    }

    private function _unset_all()
    {
        $this->session->unset_userdata('filter');
    }    

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */