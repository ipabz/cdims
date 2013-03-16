<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->check_logined_validity();
    }
    
    function check_logined_validity() {
        
        if ($this->session->userdata('id_number') && $this->session->userdata('id_number') != '') {
            //allow
            if (($this->uri->segment(1) == 'login' OR $this->uri->segment(1) == '') && ! $this->input->post('login')) {
                redirect('dashboard');
            }
        } else {
            if ($this->uri->segment(1) != 'login' && $this->uri->segment(1) != '') {
                redirect();
            }
        }
    }
    
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */