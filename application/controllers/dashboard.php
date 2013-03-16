<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('report_handler');
    }
    
    function index() {
        
        $head = array(
            'title' => 'Home'
        );
	
		$data = $this->defective_devices();
		
		$data['trans_query'] = $this->transaction_handler->transaction_lists(0,5,$this->input->post('start-date'),$this->input->post('end-date'), $this->input->post('transaction-type'));
		
        $this->load->view('html_head', $head);
        $this->load->view('header');
		$this->load->view('dashboard/dashboard-page', @$data);
        $this->load->view('footer');
        
    }
	
	function defective_devices($location='',$device_type='',$ct='',$w='',$page=NULL) {
		
		$this->load->model('device_handler');
		
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
        
        $per_page = 5;
		
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
		
		$dvs = $this->device_handler->devices($page, $per_page, $location, $device_type, $ct, $w, 'Defective');
		
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
		
        //$this->pagination->initialize($config); 
        /*
        $head = array(
            'title' => 'Devices'
        );
        */
        //$this->load->model('transaction_handler');

       
       return $data;
    
		
	}
	
	function cisco_lab() {
            
                $data = array(
                    'table_four' => $this->report_handler->graphical_workstations(23, 2),
					'table_four_id' => 23,
					'table_three' => $this->report_handler->graphical_workstations(22, 2),
					'table_three_id' => 22,
					'table_two' => $this->report_handler->graphical_workstations(21, 2),
					'table_two_id' => 21,
					'table_one' => $this->report_handler->graphical_workstations(20, 2),
					'table_one_id' => 20
                );
                
		$this->load->view("dashboard/cisco", $data);
	}
	
	function it_lab() {
		
		$data = array(
					'table_one' => $this->report_handler->graphical_workstations(1, 1),
					'table_one_id' => 1,
					'table_two' => $this->report_handler->graphical_workstations(2, 1),
					'table_two_id' => 2,
					'table_three' => $this->report_handler->graphical_workstations(4, 1),
					'table_three_id' => 4,
					'table_four' => $this->report_handler->graphical_workstations(6, 1),
					'table_four_id' => 6,
					'table_five' => $this->report_handler->graphical_workstations(8, 1),
					'table_five_id' => 8,
					'table_six' => $this->report_handler->graphical_workstations(12, 1),
					'table_six_id' => 12,
					'table_seven' => $this->report_handler->graphical_workstations(16, 1),
					'table_seven_id' => 16,
					'table_eight' => $this->report_handler->graphical_workstations(17, 1),
					'table_eight_id' => 17,
					'table_nine' => $this->report_handler->graphical_workstations(13, 1),
					'table_nine_id' => 13,
					'table_ten' => $this->report_handler->graphical_workstations(9, 1),
					'table_ten_id' => 9,
					'table_eleven' => $this->report_handler->graphical_workstations(7, 1),
					'table_eleven_id' => 7,
					'table_twelve' => $this->report_handler->graphical_workstations(5, 1),
					'table_twelve_id' => 5,
					'table_thirteen' => $this->report_handler->graphical_workstations(3, 1),
					'table_thirteen_id' => 3,
					'table_fourteen' => $this->report_handler->graphical_workstations(18, 1),
					'table_fourteen_id' => 18,
					'table_fifthteen' => $this->report_handler->graphical_workstations(14, 1),
					'table_fifthteen_id' => 14,
					'table_sixthteen' => $this->report_handler->graphical_workstations(10, 1),
					'table_sixthteen_id' => 10,
					'table_seventhteen' => $this->report_handler->graphical_workstations(11, 1),
					'table_seventhteen_id' => 11,
					'table_eightteen' => $this->report_handler->graphical_workstations(15, 1),
					'table_eightteen_id' => 15,
					'table_ninthteen' => $this->report_handler->graphical_workstations(19, 1),
					'table_ninthteen_id' => 19
                );
		
		$this->load->view("dashboard/it-lab", $data);
	}
	
	function workstation_devices() {
		
		$workstation = $this->input->post('workstation');
		$table_id = $this->input->post('table-id');
		
		if ($workstation != '') {
			
			$query = $this->report_handler->get_devices_in_workstation($workstation, $table_id);
			
			$data = array(
				'query' => $query
			);
			
			$this->load->view('dashboard/workstation_devices', $data);
			
		}
		
	}
	
	function get_updates() {
		
		$timestamp = $this->input->post('timestamp');
		$current_time = filectime('data.txt');
		
		while($current_time < $timestamp) {
			
			clearstatcache();
			
			$current_time = filectime('data.txt');
			
		}
		
		$file = file_get_contents('data.txt', 'r');
		
		$data = array(
			'timestamp' => $current_time,
			'message' => $file,
			'prev_timestamp' => $timestamp
		);
		
		print json_encode($data);
		
	}
    
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */