<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('transaction_handler');
    }
    
    function add_new() {
        
        $query = $this->transaction_handler->person_incharge();
        
        $pi = array();
        
        foreach($query->result_array() as $row) {
            
            $pi[$row['person_incharge_id']] = $row;
            
        }
        
        $data = array(
            'transaction_types' => $this->transaction_handler->getTransactionTypes(),
            'device_categories' => $this->transaction_handler->getDeviceCategories(),
            'locations' => $this->transaction_handler->getLocations(),
            'person_incharge' => $pi
        );
        
        $this->load->view('transaction/add-new', $data);
        
    }
    
    function transaction_list($offset=0) {
		
		$this->load->model('device_handler');
		
		if ($this->input->post('start-date') && $this->input->post('end-date') && $this->input->post('transaction-type')) {
			$this->session->set_userdata('start-date', $this->input->post('start-date'));
			$this->session->set_userdata('end-date', $this->input->post('end-date'));
			$this->session->set_userdata('transaction-type', $this->input->post('transaction-type'));
		}
		
		if ($this->input->post('clear')) { 
			$this->session->unset_userdata('start-date');
			$this->session->unset_userdata('end-date');
			$this->session->unset_userdata('transaction-type');
			unset($_POST['start-date']);
			unset($_POST['end-date']);
		}
		
		if ($this->session->userdata('start-date') && $this->session->userdata('end-date')) {
			$_POST['start-date'] = $this->session->userdata('start-date');
			$_POST['end-date'] = $this->session->userdata('end-date');
			$_POST['transaction-type'] = $this->session->userdata('transaction-type');
		}
		
		
		
		$per_page = 20;
		
        $head = array(
            'title' => 'Transaction List'
        );
		
		
		$transaction_types = $this->transaction_handler->getTransactionTypes();
		$transaction_types[''] = 'All';
		
		$data = array(
			'query' => $this->transaction_handler->transaction_lists($offset,$per_page,$this->input->post('start-date'),$this->input->post('end-date'), $this->input->post('transaction-type')),
			'transaction_types' => $transaction_types
		);
		
		$config['base_url'] = site_url('transaction/transaction_list/');
        $config['total_rows'] = $this->transaction_handler->count_all_transactions($this->input->post('start-date'),$this->input->post('end-date'), $this->input->post('transaction-type'));
        $config['per_page'] = "$per_page";
		
		
		$this->load->library('pagination');
		
		$this->pagination->initialize($config); 

        $this->load->view('html_head', $head);
        $this->load->view('header');
        $this->load->view('transaction/transaction-list', $data);
        $this->load->view('footer');
        
    }
    
    function device_options() {
        
        $device_type = $this->input->post('device-type');
        
        if ($device_type != '') {
        
            $data = array(
                'device_type' => $device_type,
                'inputs' => $this->transaction_handler->get_inputs($device_type),
                'devices_inside' => $this->transaction_handler->devices_inside($device_type)
            );

            $this->load->view('transaction/device-options', $data);

        } else {
            print '<hr /><div style="width: 97%"><div class="error-container"><div class="error" align="left">Please select a device type.</div></div></div>';
        }
        
    }
    
    function predevices_of_type() {
        
        $device_type = $this->input->post('device-type');
        
        if ($device_type != '') {
            
            $data = array(
                'devices' => $this->transaction_handler->get_predevices_of_type($device_type),
                'src' => $this->input->post('src')
            );
            
            $this->load->view('transaction/choose-devices', $data);
            
        }
        
    }
    
    function select_device_type_form() {
        
        $this->load->view('transaction/select-device-type');
        
    }
    
    function computer_tables() {
        
        $location_id = $this->input->post('location-id');
        
        if ($location_id != '') {
            
            $query = $this->transaction_handler->getComputerTables_in($location_id);
            
            $data = array(
                '' => ' [ Select one ] '
            );
            
            foreach ($query->result() as $row) {
                
                $data[$row->computer_table_id] = 'Table '.$row->name;
                
            }
            
            print '<td>Computer table </td><td>'.form_dropdown('computer-tables', $data, '', 'id="ts" class="computer-table-select tse" onchange="transaction.workstation_option(\''.site_url('transaction/workstations').'\', this.value, \'.c-table-option\')"').'&nbsp;<span class="loading-here2"></span></td>';
            
        }
        
    }
    
    function workstations() {
        
        $computer_table = $this->input->post('computer-table');
        
        if ($computer_table != '') {
            
            $workstations = $this->transaction_handler->getAvailableWorstation_in($computer_table);
            
            print '<td>Workstation </td><td>'.form_dropdown('workstations', $workstations, '', 'onclick="transaction.change_w(this.value)" class="workstation-select"').'</td>';
            
        }
        
    }
    
    function get_person_incharge($id_number) {
        
        if ($id_number != '') {
            
            $person_incharge = $this->transaction_handler->get_person_incharge($id_number);
            
            print json_encode($person_incharge);
            
        }
        
        
    }
	
	function add_new_transaction_existing() {
		
		$transaction_type = $this->input->post('transaction-type');
        $location = $this->input->post('location');
        $table = $this->input->post('table');
        $workstation = $this->input->post('workstation');
        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $contact_number = $this->input->post('contact-number');
        $id_number = $this->input->post('id-number');
		$more_info = $this->input->post('more_info');
		$device_id = $this->input->post('device-id');
		
		$device = $this->transaction_handler->getdevice($device_id);
		
		if (! $this->transaction_handler->has_duplicate($device->device_type_id, $workstation, $table)) {
			$this->transaction_handler->add_transaction_existing(
				$transaction_type,
				$device_id,
				$location,
				$table,
				$workstation,
				$fname,
				$lname,
				$contact_number,
				$id_number,
				$more_info
			);
		} else {
			print 'error';	
		}
		
	}
    
    function add_new_transaction() {
        
        $transaction_type = $this->input->post('transaction-type');
        $device_name = $this->input->post('device-name');
        $device_type = $this->input->post('device-type');
        $option = $this->input->post('option');
        $specs = $this->input->post('specs');
        $devices = $this->input->post('devices');
        $location = $this->input->post('location');
        $table = $this->input->post('table');
        $workstation = $this->input->post('workstation');
        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $contact_number = $this->input->post('contact-number');
        $id_number = $this->input->post('id-number');
		$more_info = $this->input->post('more_info');
        
        if ($device_name != '' && $device_type != '' && $option != '' && $specs != '' && $location != '' && $table != '' && $workstation != '' && $fname != '' && $lname != '' && $contact_number != '' && $id_number) {
            
			if (! $this->transaction_handler->has_duplicate($device_type, $workstation, $table)) {
			
				$this->transaction_handler->add_transaction(
							$transaction_type,
							$device_name,
							$device_type,
							$option,
							$specs,
							$devices,
							$location,
							$table,
							$workstation,
							$fname,
							$lname,
							$contact_number,
							$id_number,
							$more_info
						);
			
			} else {
				print 'error';	
			}
            
        }
        
        
    }
    
    function search_get_specs() {
        
        $device_type = $this->input->post('device-type');
        
        $inputs = $this->transaction_handler->get_inputs($device_type);
        
        $data = array(''=>'[ Specification ]');
        
        if ($inputs != NULL) {
            foreach ($inputs->result() as $row) {
                $data[$row->name] = $row->name;
            }
        }
        
        print form_dropdown('specs', $data, '', 'style="padding: 2px;" class="specs-select" onclick="existing_select_specs(this.value)"');
        
    }
    
    function search_now() {
        
        $device_type = $this->input->post('device-type');
        $spec = $this->input->post('spec');
        $keyword = $this->input->post('keyword');
        
    }
	
	function devices_in_loc() {
		
		$location = $this->input->post('location');
		$table = $this->input->post('table');
		$workstation = $this->input->post('workstation');
		
		if ($location != '' && $table != '' && $workstation != '') {
			
			$query = $this->transaction_handler->devices_in($location,$table,$workstation);
			
			$this->load->view('transaction/devices-in-location', array('query'=> $query));
			
		} else {
			print "$location - $table - $workstation";	
		}
		
	}
	
	function add_transaction_so() {
		
		$transaction_type = $this->input->post('transaction-type');
		$fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $contact_number = $this->input->post('contact_number');
        $id_number = $this->input->post('id_number');
		$devices = $this->input->post('devices');
		$more_info = $this->input->post('more_info');
		
		$devs = explode('::::', $devices);
		
		if ($transaction_type != '' && $fname != '' && $lname != '' && $contact_number != '' && $id_number != '') {
			
			$this->transaction_handler->stockout_add_transaction(
				$transaction_type,
				$devs,
				array(
					'id_number' => $id_number,
					'firstname' => $fname,
					'lastname' => $lname,
					'contact_number' => $contact_number
				),
				$more_info
			);
			
		}
			
	}
    
}

/* End of file transaction.php */
/* Location: ./application/controllers/transaction.php */