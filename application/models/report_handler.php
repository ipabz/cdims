<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_handler extends CI_Model {
	
	function __construct() {
		parent::__construct();	
	}
	
	function tabular_generate_reportd($offset=0,$limit=20,$location='',$device_type='',$spec_name='',$spec_value='', $sort_by=NULL) {
		
		$d_l = array();
		$d_t = array();
		
		if ($location != '') {
			$temp = array();
			
			$sql = "
				SELECT
					workstation.*
				FROM
					workstation
				WHERE
					location_id = '$location'
			";
			
			if (@$computer_table != '' && @$computer_table !== 0) {
				$sql .= " AND computer_table_id = '$computer_table'";
			}
			
			if (@$workstation != '' && @$workstation !== 0) {
				$sql .= " AND name = '$workstation'";
			}
			
			$query = $this->db->query($sql);
			
			foreach($query->result() as $row) {
				$d_l[$row->device_id] = $row->device_id;
				//$temp = $this->get_sub_devices($row->device_id);
				//$this->arraypush($temp, $d_l);
			}
		
		} else {
			
			$sql = "
				SELECT
					workstation.*
				FROM
					workstation
			";
			
			$query = $this->db->query($sql);
			
			foreach($query->result() as $row) {
				$d_l[$row->device_id] = $row->device_id;
				//$temp = $this->get_sub_devices($row->device_id);
				//$this->arraypush($temp, $d_l);
			}
			
		}
		
		if ($device_type != '') { 
			
			$this->db->where('device_type_id', $device_type);
			$query = $this->db->get('device');
			
			$temp = array();
			
			foreach($query->result() as $row) {
				$d_t[$row->device_id] = $row->device_id;
				
				if (in_array($row->device_id, $d_l)) {
					$temp[$row->device_id] = $row->device_id;
				}
			}
			
			$d_l = $temp;
			
			if ($query->num_rows() == 0) {
				$d_l = array();
			}
			
		}
		
		$sql = "
			SELECT
				device.*,
				device_type.device_type
			FROM
				device
			INNER JOIN
				device_type
			ON
				device.device_type_id = device_type.device_type_id
		";
		
		$where = '';
		
		foreach($d_l as $r) {
			if ($where == '') {
				$where = "WHERE device.device_id = '$r'";
			} else {
				$where .= " OR device.device_id = '$r'";	
			}
		}
		
		if (@$computer_table == '' && @$workstation == '') {
			if (count($d_l) == 0) {
				$sql .= " WHERE device.device_type_id = '$device_type'";
			}
		} else {
			if (count($d_l) == 0) {
			
				$sql .= "
						,location,
						computer_table,
						workstation 
					WHERE
						workstation.computer_table_id = computer_table.computer_table_id AND
						computer_table.location_id = location.location_id AND
						location.location_id = '$location' AND
						device.device_id = workstation.device_id AND
						computer_table.computer_table_id = '$computer_table' AND
						workstation.name = '$workstation'
					";	
					
				if ($device_type != '') {
					$sql .= " AND device.device_type_id = '$device_type'";
				}
					
			}
		}
		
		$sql = $sql . $where;
		
		//$sql .= " LIMIT $offset, $limit";
		$sql .= " AND device.device_status = 'Active'";
		//print $sql;
		
		return $this->db->query($sql);
		
	}
	
	function tabular_generate_report($offset=0,$limit=20,$location='',$device_type='',$spec_name='',$spec_value='', $sort_by=NULL) {
		
		$devices = array();
		
		if ($spec_name != '' && $spec_value != '') {
			
			$this->db->where('name', $spec_name);
			$this->db->where('value', $spec_value);
			$query = $this->db->get('specification');
			
			foreach($query->result() as $row) {
				$devices[] = $row->device_id;
			}
			
			if ($location != '') { 
				
				$this->db->where('location_id', $location);
				$query = $this->db->get('workstation');
				$tmp = array();
				
				foreach($query->result() as $row) {
					$tmp[] = $row->device_id;
					
					$sub_query = $this->device_handler->get_sub_devices($row->device_id);
					$tmp = array_merge($tmp, $sub_query);
				}
				//print_r($tmp);
				$devices = array_intersect($tmp, $devices);
				//$devices = $tmp;
			}
		
		}
		
		$sql = "
			SELECT
				device.*,
				device_type.device_type
			FROM
				device
		";
		
		if ($location != '') {
			
			$sql .= "
				, location,
				computer_table,
				workstation,
				device_type
			";
			
		} else {
		
			$sql .= "
				INNER JOIN
					device_type
				ON
					device.device_type_id = device_type.device_type_id
			";
		
		}
		
		$sql .= "
				
			WHERE
				device.device_status = 'Active'
		";
		
		if ($location != '') {
			
			$sql .= "
				AND workstation.computer_table_id = computer_table.computer_table_id AND
				computer_table.location_id = location.location_id AND
				location.location_id = '$location' AND
				device.device_id = workstation.device_id AND
				device.device_type_id = device_type.device_type_id
			";
			
		}
		
		if ($device_type != '') {
			
			$sql .= " AND device_type.device_type_id = '$device_type'";
			
		}
		
		if ($spec_name != '' && $spec_value != '' && count($devices) > 0) {
			
			$sql .= " AND
				(
			";
			
			$addon = '';
			
			foreach($devices as $id) {
				if($addon == '') {
					$addon = "device.device_id = '$id'";
				} else {
					$addon .= " OR device.device_id = '$id'";	
				}
			}
			
			$sql .= $addon;
			
			$sql .= "	
				)
			";
			
		}
		
		/*
		$sql .= "	
		
			LIMIT $offset, $limit
		";
		*/
		
		$sql .= " ORDER BY device.device_type_id ASC";
		
		//print $sql;
		
		if ($sort_by != NULL) {
			$sql .= " ORDER BY $sort_by";
		}
		//print $sql;
		$query = $this->db->query($sql);
		
		if($location != '' && $device_type != '' && $spec_name != '' && $spec_value != '') {
			if ($query->num_rows() == 0) {
				$query = $this->recheck_db($offset,$limit,$location,$device_type,$spec_name,$spec_value);
			}
		} else if($location != '' && $device_type != '') {
			if ($query->num_rows() == 0) {
				$query = $this->recheck_db($offset,$limit,$location,$device_type,$spec_name,$spec_value);
			}
		}
		
		return $query;
		
	}
	
	protected function recheck_db($offset=0,$limit=20,$location='',$device_type='',$spec_name='',$spec_value='') {
		
		$this->load->model('device_handler');
		
		$devices = array();
		
		if ($spec_name != '' && $spec_value != '') {
			
			$this->db->where('name', $spec_name);
			$this->db->where('value', $spec_value);
			$query = $this->db->get('specification');
			
			foreach($query->result() as $row) {
				$devices[] = $row->device_id;
			}
			
			if ($location != '') { 
				
				$this->db->where('location_id', $location);
				$query = $this->db->get('workstation');
				$tmp = array();
				
				foreach($query->result() as $row) {
					$tmp[] = $row->device_id;
					
					$sub_query = $this->device_handler->get_sub_devices($row->device_id);
					$tmp = array_merge($tmp, $sub_query);
				}
				//print_r($tmp);
				$devices = array_intersect($tmp, $devices);
				//$devices = $tmp;
			}
		
		}
		
		$sql = "
			SELECT
				device.*,
				device_type.device_type
			FROM
				device,
				device_type
			WHERE
				device.device_type_id = device_type.device_type_id AND
				device.device_type_id = '$device_type' AND
				device.device_status = 'Active'
		";
		
		if (count($devices) > 0) {
			
			$addon = '';
			
			foreach($devices as $d_id) {
				
				if ($addon == '') {
					$addon = "device.device_id = '$d_id'";
				} else {
					$addon .= " OR device.device_id = '$d_id'";	
				}
				
			}
			
			$sql .= " AND (".$addon.")";
			
		}
		
		$sql .= "
			LIMIT $offset, $limit
		";
		//print $sql;
		$query = $this->db->query($sql);
		
		return $query;
		
	}
        
        function  graphical_workstations($computer_table,$location) {
            
            $this->db->where('computer_table_id', $computer_table);
			$this->db->where('location_id', $location);
            $this->db->group_by('name');
            $query = $this->db->get('workstation');
            
            return $query;
            
        }
		
		function get_devices_in_workstation($workstation_name, $table_id = NULL) {
			
			$this->db->where('name', $workstation_name);
			$this->db->where('computer_table_id', $table_id);
			$this->db->order_by('workstation_id');
			$query = $this->db->get('workstation');
			
			$where = '';
			
			foreach($query->result() as $row) {
				if ($where == '') {
					$where = 'device_id = "'.$row->device_id.'"';
				} else {
					$where .= ' OR device_id = "'.$row->device_id.'"';
				}
			}
			
			$sql = "
				SELECT
					device.*,
					device_type.device_type
				FROM
					device
				INNER JOIN
					device_type
				ON
					device.device_type_id = device_type.device_type_id
				WHERE 
					device.device_status = 'Active' AND (
			" . $where . " ) ORDER BY device.name";
			
			$query = $this->db->query($sql);
			
			return $query;
			
		}
		
		function get_location_details($location_id) {
			
			$this->db->where('location_id', $location_id);
			$query = $this->db->get('location');
			
			return $query->row();
			
		}
		
		function summary() {
		
		}
		
}

/* End of file report_handler.php */
/* Location: ./application/models/report_handler.php */