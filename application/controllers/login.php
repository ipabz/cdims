<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        
        $head = array(
            'title' => 'Login'
        );

        $this->load->view('html_head', $head);
        $this->load->view('login-page');
        $this->load->view('footer');
        
    }
    
    function do_login() {
        
        if ($this->input->post('login')) {
            
            $this->load->library('form_validation');
            
            $config = array(
                           array(
                                 'field'   => 'id-number',
                                 'label'   => 'ID Number',
                                 'rules'   => 'required|alpha_numeric'
                              ),
                           array(
                                 'field'   => 'password',
                                 'label'   => 'Password',
                                 'rules'   => 'required'
                              )
                        );

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules($config); 

            if ($this->form_validation->run() == FALSE) {
                print '<div class="error-container">' . validation_errors() . '</div>';
            } else {
                    
                $this->load->model('account_handler');
                
                $success = $this->account_handler->login(
                                    $this->input->post('id-number'),
                                    $this->input->post('password')
                                );
 
                if ($success) {
                    print 1;
                } else {
                    print '<div class="error-container"><div class="error">Invalid ID Number or Password.</div></div>';
                }
                
            }
            
            
        }
        
    }
    
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */