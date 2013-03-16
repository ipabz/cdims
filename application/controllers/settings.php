<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('settings_handler');
    }
    
    function predefined_devices() {
        
        $data = array(
            'devices' => $this->settings_handler->getPredefinedDevices()
        );
        
        $this->load->view('settings/predefined_devices/predefined-devices', $data);
    }	
	
    function new_predefined_device() {
        
        $this->load->model('transaction_handler');
        
        $data = array(
            'device_types' => $this->transaction_handler->getDeviceCategories()
        );
        
        $this->load->view('settings/predefined_devices/new-device', $data);
    }
    
    function add_spec() {
        $this->load->view('settings/predefined_devices/add-spec');
    }
    
    function add_device() {
        
        $device_name = $this->input->post('device-name');
        $device_type = $this->input->post('device-type');
        $specs = explode('<->', $this->input->post('specs'));
        $devices = $this->input->post('devices');
        
        $device_id = $this->settings_handler->add_device(
                    $device_name,
                    $device_type,
                    $devices
                );
        
        foreach($specs as $row) {
            $temp = explode('----', $row);
            
            $this->settings_handler->add_specs(
                        $device_id,
                        $temp[0],
                        $temp[1]
                    );
        }
        
        //var_dump($temp);
        
        print '-1';
        
    }
    
    function edit_pre_device_form($device_id) {
        
        if ( ! $this->settings_handler->predefined_device_exists($device_id)) {
            
            print '-1';
            
        } else {
        
            $this->load->model('transaction_handler');
			
			$di = $this->settings_handler->get_predefined_device_info($device_id);
			
            $data = array(
                'device_types' => $this->transaction_handler->getDeviceCategories(),
                'device_info' => $di,
                'specs' => $this->settings_handler->get_predefined_device_specs($device_id),
                'devices' => $this->settings_handler->get_devicetypes($device_id),
				'dtype' => $this->settings_handler->get_device_type($di->device_type_id)
            );

            $this->load->view('settings/predefined_devices/edit-device', $data);
        
        }
        
    }
    
    function edit_pre_device() {
        
        $device_name = $this->input->post('device-name');
        $device_type = $this->input->post('device-type');
        $device_id = $this->input->post('device-id');
        $temp = explode('<->', $this->input->post('specs'));
        $devices = $this->input->post('devices');
        
        if ($this->settings_handler->predefined_device_exists($device_id)) {
            
            $specs = array();
            
            foreach ($temp as $row) {
                $tmp = explode('----', $row);
                $specs[$tmp[0]] = $tmp[1];
            }
            
            $this->settings_handler->update_pre_device(
                        $device_id,
                        $device_name,
                        $device_type,
                        $specs,
                        $devices
                    );
            
        }
        
    }
    
    function delete_predefined_device($device_id) {
        
        $this->settings_handler->delete_predefined_device($device_id);
        
    }
    
    function locations() {
        
        $data = array(
            'locations' => $this->settings_handler->locations()
        );
        
        $this->load->view('settings/locations/locations', $data);
    }
    
    function new_location_form() {
        
        $this->load->view('settings/locations/new-location');
        
    }
    
    function new_location() {
        
        $location_name = $this->input->post('location-name');
        $num_computer_table = $this->input->post('num-computer-table');
        $num_workstation = $this->input->post('num-workstation');
        
        $this->settings_handler->add_location(
                    $location_name,
                    $num_computer_table,
                    $num_workstation
                );
        
    }
    
    function edit_location_form($location_id) {
        
        if ($this->settings_handler->is_valid_location($location_id)) {
            
            $data = array(
                'location_info' => $this->settings_handler->get_location_info($location_id)
            );
            
            $this->load->view('settings/locations/edit-location', $data);
            
        } else {
            print '-1';
        }
        
    }
    
    function edit_location($location_id) {
        
        $location_name = $this->input->post('location-name');
        $num_computer_table = $this->input->post('num-computer-table');
        $num_workstation = $this->input->post('num-workstation');
        
        if ($this->settings_handler->is_valid_location($location_id)) {
            
            $this->settings_handler->edit_location(
                        $location_id,
                        $location_name,
                        $num_computer_table,
                        $num_workstation
                    );
            
        }
        
    }
    
    function delete_location($location_id) {
        
        if ($this->settings_handler->is_valid_location($location_id)) {
            
            $this->settings_handler->delete_location($location_id);
            
        }
        
    }
    
    function select_device() {
        
        $data = array(
            'device_types' => $this->settings_handler->get_device_types()
        );
        
        $this->load->view('settings/predefined_devices/select-device-type', $data);
        
    }
    
    function device_types() {
        
        $data = array(
            'device_types' => $this->settings_handler->get_device_types()
        );
        
        $this->load->view('settings/device_types/device-types', $data);
        
    }
    
    function new_device_type() {
        
        $this->load->view('settings/device_types/new-device-type');
        
    }
    
    function add_device_type() {
        
        $device_type = trim($this->input->post('device-type'));
		$inner = $this->input->post('inner');
		$with_devices = $this->input->post('with-devices');
        
        if ($device_type != '') {
            
            $this->settings_handler->add_device_type($device_type,$inner,$with_devices);
            
        }
        
    }
    
    function delete_device_type() {
        
        $device_type = trim($this->input->post('device-type'));
        
        if ($device_type != '') {
            
            $this->settings_handler->delete_device_type($device_type);
            
        }
        
    }
    
    function edit_device_type_form() {
        
        $device_type = trim($this->input->post('device-type'));
        
        if ($device_type != '') {
            
            $data = array(
                'device_type' => $this->settings_handler->get_device_type($device_type)
            );
            
            $this->load->view('settings/device_types/edit-device-type', $data);
            
        }
        
    }
    
    function edit_device_type($device_type_id,$device_type,$inner,$with_devices) {
        
        $device_type = str_replace('%20', ' ', $device_type);
        
        if ($device_type != '' && $device_type_id != '') {
            
            $this->settings_handler->edit_device_type(
                        $device_type_id,
                        $device_type,
						$inner,
						$with_devices
                    );
            
        }
        
    }
    
	function getdevice_type($type=0) {
		
		if ($type != '') {
			$dtype = $this->settings_handler->get_device_type($type);
			
			print $dtype->with_devices;
		}
		
	}
	
	function gdt($type=0) {
		if ($type != '') {
			$dtype = $this->settings_handler->get_device_type($type);
			
			print $dtype->inner_device;
		}
	}
    
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */