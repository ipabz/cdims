<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('account_handler');
    }
    
    function index() {
        
        $head = array(
            'title' => 'Account'
        );

        $this->load->view('html_head', $head);
        $this->load->view('header');
        $this->load->view('footer');
        
    }
    
    function logout() {
        
        $this->session->sess_destroy();
        redirect('login');
        
    }
    
    function manage_account() {
        
        $data = array(
            'accounts' => $this->account_handler->get_accounts()
        );
        
        $this->load->view('account/manage-account', $data);
        
    }
    
    function new_account_form() {
        
        $account_types = array(
            '' => '[ Select one ]'
        );
        $query = $this->account_handler->get_account_types();
        
        foreach($query->result() as $row) {
            $account_types[$row->account_type_id] = ucwords($row->account_type);
        }
        
        $data = array(
            'account_types' => $account_types
        );
        
        $this->load->view('account/new-account', $data);
        
    }
    
    function edit_account_form($id_number) {
        
        if ($this->account_handler->account_exists($id_number)) {
        
            $account_types = array(
                '' => '[ Select one ]'
            );
            $query = $this->account_handler->get_account_types();

            foreach($query->result() as $row) {
                $account_types[$row->account_type_id] = ucwords($row->account_type);
            }

            $data = array(
                'account_types' => $account_types,
                'account' => $this->account_handler->get_account($id_number)
            );

            $this->load->view('account/edit-account', $data);
        
        }
        
    }
    
    
    function save_new_account() {
        
        $id_number = $this->input->post('id-number');
        $first_name = $this->input->post('first-name');
        $last_name = $this->input->post('last-name');
        $contact_number = $this->input->post('contact-number');
        $account_status = $this->input->post('account-status');
        $account_type = $this->input->post('account-type');
        $password = $this->input->post('password');
        
        if ($id_number != '' && $first_name != '' && $last_name != '' && $contact_number != '' && $account_type != '' && $password != '') {
            
            $this->account_handler->save_new_account(
                        $id_number,
                        $first_name,
                        $last_name,
                        $contact_number,
                        $account_status,
                        $account_type,
                        $password
                    );
            
        } else {
            print -1;
        }
        
    }
    
    function update_account() {
        
        $id_number = $this->input->post('id-number');
        $first_name = $this->input->post('first-name');
        $last_name = $this->input->post('last-name');
        $contact_number = $this->input->post('contact-number');
        $account_status = $this->input->post('account-status');
        $account_type = $this->input->post('account-type');
        $password = $this->input->post('password');
        
        if ($id_number != '' && $first_name != '' && $last_name != '' && $contact_number != '' && $account_type != '' && $password != '') {
            
            $this->account_handler->update_account(
                        $id_number,
                        $first_name,
                        $last_name,
                        $contact_number,
                        $account_status,
                        $account_type,
                        $password
                    );
            
        } else {
            print -1;
        }
        
    }
    
    function validate_id_number() {
        
        $id_number = trim($this->input->post('id-number'));
        
        if ($id_number != '') {
            
            $exists = $this->account_handler->account_exists($id_number);
            
            if ($exists) {
                print '<div class="id-notice" style="color: red;">ID Number already exists!</div>';
            }
            
        }
        
    }
    
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */