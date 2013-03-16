<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_handler extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function login($id_number,$password) {
        
        $sql = "
            SELECT
                account.*,
				account_type.account_type
            FROM
                account
            INNER JOIN
                account_type
            ON
                account.account_type_id = account_type.account_type_id
            WHERE
                account.account_id = '$id_number' AND
                account.password = '".sha1($password)."'
              
        ";
        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            
            $row = $query->row();
            
            $data = array(
                'first_name' => $row->firstname,
                'last_name' => $row->lastname,
                'id_number' => $row->account_id,
                'contact_number' => $row->contact_number,
                'account_type' => $row->account_type_id,
				'acc_type' => $row->account_type
            );
            
            $this->session->set_userdata($data);

            return TRUE;
            
        }
        
        return FALSE;
        
    }
    
    function get_accounts() {
        
        $sql = "
            SELECT
                account.*,
                account_type.account_type
            FROM
                account
            INNER JOIN
                account_type
            ON
                account.account_type_id = account_type.account_type_id
        ";
        
        $query = $this->db->query($sql);
        
        return $query;
        
    }
    
    function get_account_types() {
        
        $query = $this->db->get('account_type');
        
        return $query;
        
    }
    
    function to_array($query) {
        
        $data = array();
        
        foreach($query->result_array() as $row) {
            $data[] = $row;
        }
        
    }
    
    function save_new_account($id_number,$first_name,$last_name,$contact_number,$account_status,$account_type,$password) {
        
        $data = array(
            'account_id' => $id_number,
            'firstname' => $first_name,
            'lastname' => $last_name,
            'contact_number' => $contact_number,
            'account_status' => $account_status,
            'account_type_id' => $account_type,
            'password' => sha1($password)
        );
        
        $this->db->insert('account', $data);
        
    }
    
    function get_account($id_number) {
        
        $this->db->where('account_id', $id_number);
        $query = $this->db->get('account');
        
        return $query->row();
        
    }
    
    function account_exists($id_number) {
        
        $this->db->where('account_id', $id_number);
        $query = $this->db->get('account');
        
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        
        return FALSE;
        
    }
    
    function update_account($id_number,$first_name,$last_name,$contact_number,$account_status,$account_type,$password) {
        
        $data = array(
            'account_id' => $id_number,
            'firstname' => $first_name,
            'lastname' => $last_name,
            'contact_number' => $contact_number,
            'account_status' => $account_status,
            'account_type_id' => $account_type,
            'password' => sha1($password)
        );
        
        $this->db->where('account_id', $id_number);
        $this->db->update('account', $data);
        
    }
    
}

/* End of file account_handler.php */
/* Location: ./application/models/account_handler.php */