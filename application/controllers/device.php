<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('device_handler');
    }
	
	function defective_devices_lists($keyword='',$page=0) {
		$this->load->model('transaction_handler');
		
		$head = array(
            'title' => 'Defective Devices'
        );
		
		$offset = ($page) ? $page : 0;
		$limit = 20;
		$total = 20;
		
		if (! $this->input->post('keyword')) {
			$_POST['keyword'] = $keyword;
		} else {
			$keyword = 	$this->input->post('keyword');
		}
		
		$this->load->library('pagination');

        $config['base_url'] = site_url('search/index/'.(($keyword) ? $keyword.'/' : ''));
		//$config['base_url'] = site_url('device/devices/');
        $config['total_rows'] = $this->device_handler->search_count($this->input->post('keyword'));
        $config['per_page'] = "$limit";
		$config['uri_segment'] = '4';
		
		
		$data = array(
			'devices' => $this->device_handler->search($this->input->post('keyword'), $offset, $limit),
			'offset' => $offset + 1,
			'to' => (($limit + $offset) < $config['total_rows']) ? ($limit + $offset) : $config['total_rows'],
			'total' => $config['total_rows'],
			'title' => 'Defective Devices'
		);
		
		$this->pagination->initialize($config); 
		
        $this->load->view('html_head', $head);
        $this->load->view('header');
        $this->load->view('search/results', @$data);
        $this->load->view('footer');
	
	}
    
    function devices($location='',$device_type='',$ct='',$w='',$page=NULL) {
		
		if ($this->input->post('computer-table')) {
			$ct = $this->input->post('computer-table');
		} else if ($ct == 0) {
			$ct = '';
		}
		
		$_POST['computer-table'] = $ct;
		
		if ($this->input->post('workstation')) {
			$w = $this->input->post('workstation');
		} else if ($w == 0) {
			$w = '';
		}
		
		if ($ct == '') {
			$w = '';
		}
		
		$_POST['computer-table'] = $ct;
		
		$this->load->model('transaction_handler');
		
		$computer_tables = array(''=>'All');
		$workstations = array(''=>'All');
		
		if ($this->input->post('location') OR $location) {
			$location = ($this->input->post('location')) ? $this->input->post('location') : $location;
			
			$computer_tables_q = $this->transaction_handler->getComputerTables_in($location);
			
			foreach($computer_tables_q->result() as $row) {
				$computer_tables[$row->computer_table_id] = $row->name;
			}
		} else if ($location == 0) {
			$location = '';
		}
		
		$_POST['location'] = $location;		
		
		if ($this->input->post('device-type')) {
			$device_type = $this->input->post('device-type');
		} else if ($device_type == 0) {
			$device_type = '';
		}
		
		$_POST['device-type'] = $device_type;
		
		
		if ($ct != '' && $location != '') {
			$workstations = $this->transaction_handler->getAvailableWorstation_in($this->input->post('computer-table'));
			$workstations[''] = 'All';
		}
		
        
        $page = ($page == NULL) ? 0 : $page;
        
        $per_page = 20;
		
		$this->load->model('transaction_handler');
		
		$locations = $this->transaction_handler->getLocations();
		$locations[''] = 'All';
        
        
        
        $this->load->library('pagination');

        $config['base_url'] = site_url('device/devices/'.(($location) ? $location.'/' : '0/').(($device_type) ? $device_type.'/' : '0/').(($ct) ? $ct.'/' : '0/').(($w) ? $w.'/' : '0/'));
		//$config['base_url'] = site_url('device/devices/');
        $config['total_rows'] = $this->device_handler->count_devices($location, $device_type, $ct, $w);
        $config['per_page'] = "$per_page";
		$config['uri_segment'] = '7';
		/*
		if ($location != '' && $device_type != '') {
			$config['uri_segment'] = '6';
		} else if ($location != '' OR $device_type == '') {
			$config['uri_segment'] = '4';
		} else {
			$config['uri_segment'] = '3';
		}*/
		
		$dvs = $this->device_handler->devices($page, $per_page, $location, $device_type, $ct, $w);
		
		$data = array(
            'devices' => $dvs,
			'locations' => $locations,
			'device_types' => $this->device_handler->get_devicetypes(),
			'computer_tables' => $computer_tables,
			'workstations' => $workstations,
			'offset' => (($page == 0 OR $page == NULL) ? '1' : ($page + 1)),
			'to' => $page + (($dvs->num_rows() == $per_page) ? $per_page : $dvs->num_rows()),
			'total' => $config['total_rows']
        );
		
        $this->pagination->initialize($config); 
        
        $head = array(
            'title' => 'Devices'
        );
        
        $this->load->model('transaction_handler');

        $this->load->view('html_head', $head);
        $this->load->view('header');
        $this->load->view('device/devices', $data);
        $this->load->view('footer');
        
    }
	
	function device_details() {
		
		$device_id = $this->input->post('device_id');
		
		if ($device_id != '') {
			
			$data = array(
				'details' => $this->device_handler->device_details($device_id)
			);
			
			$this->load->view('device/device-details', $data);
			
		}
			
	}
	
	function edit_device() {
		
		$this->load->model('transaction_handler');
		$device_id = $this->input->post('device_id');
		
		if ($device_id != '') {
			
			$statuses = array(
				'Active' => 'Active',
				'Inactive' => 'Inactive',
				'Defective' => 'Defective'
			);
			
			$data = array(
				'details' => $this->device_handler->device_details($device_id),
				'statuses' => $statuses
			);
			
			$this->load->view('device/edit-device', $data);
			
		}
		
	}
        
        function edit_device_save() {
            
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            
            $config = array(
               array(
                     'field'   => 'device-id',
                     'label'   => 'Device ID',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'device-name',
                     'label'   => 'Device Name',
                     'rules'   => 'required'
                  )
            );

            $this->form_validation->set_rules($config); 
            
            if ($this->form_validation->run() == FALSE)
            {
                    print validation_errors();
            }
            else
            {
                    $this->device_handler->edit_device(
                                $this->input->post('device-id'),
                                $this->input->post('device-name'),
                                $this->input->post('specs'),
                                $this->input->post('devices'),
								$this->input->post('status')
                            );
            }
            
        }
		
		
		function delete_device($device_id) {
			
			if ($device_id != '') {
				
				$this->device_handler->delete_device($device_id);
				
			}
			
		}
    
}

/* End of file device.php */
/* Location: ./application/controllers/device.php */