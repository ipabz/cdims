<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Device_handler extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
	
	function get_sub_devices($device_id) {
		
		$this->db->where('parent_device', $device_id);
		$query = $this->db->get('device');
		
		$d = array();
		
		foreach($query->result() as $row) {
			$d[$row->device_id] = $row->device_id;
		}
		
		return $d;
		
	}
	
	function arraypush($values, &$array) {
		
		foreach($values as $key => $value) {
			$array[$key] = $value;
		}
		
	}
    
	function devices($offset=0,$limit=10,$location='',$device_type='',$computer_table='',$workstation='',$status='') {
		
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
			
			if ($computer_table != '' && $computer_table !== 0) {
				$sql .= " AND computer_table_id = '$computer_table'";
			}
			
			if ($workstation != '' && $workstation !== 0) {
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
				device.*
			FROM
				device
		";
		
		$where = '';
		
		foreach($d_l as $r) {
			if ($where == '') {
				$where = "WHERE ( device.device_id = '$r'";
			} else {
				$where .= " OR device.device_id = '$r'";	
			}
		}
		
		if ($computer_table == '' && $workstation == '') {
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
		
		if ($status != '') {
			
			$where .= ") AND device.device_status = '$status'";
			
		} else {
			if ($where != '') {
			 	$where .= ' )';
			}
		}
		
		$sql = $sql . $where;
		
		$sql .= " LIMIT $offset, $limit";
		
		return $this->db->query($sql);
		
	}
	
	function devices_of_type($device_type='') {
		
		$sql = "
			SELECT
				device.*
			FROM
				device
			WHERE
				device.device_type_id = '$device_type'
		";
		
		return $this->db->query($sql);
		
	}
	
    
    function count_devices($location='',$device_type='',$computer_table='',$workstation='') {
		
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
			
			if ($computer_table != '' && $computer_table != 0) {
				$sql .= " AND computer_table_id = '$computer_table'";
			}
			
			if ($workstation != '' && $workstation != 0) {
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
				device.*
			FROM
				device
		";
		
		$where = '';
		
		foreach($d_l as $r) {
			if ($where == '') {
				$where = "WHERE device.device_id = '$r'";
			} else {
				$where .= " OR device.device_id = '$r'";	
			}
		}
		
		if ($computer_table == '' && $workstation == '') {
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
		

		return $this->db->query($sql)->num_rows();
        
    }
    
    function device_location($device_id) {
        
        $sql = "
            SELECT
                location.location,
                workstation.name,
                workstation.computer_table_id
            FROM
                location
            INNER JOIN
                computer_table
            ON
                location.location_id = computer_table.location_id
            INNER JOIN
                workstation
            ON
                computer_table.computer_table_id = workstation.computer_table_id
            WHERE
                workstation.device_id = '$device_id'
        ";
        
        $query = $this->db->query($sql);
		
		if ($query->num_rows() == 0) {
			
			$this->db->where('device_id', $device_id);
			$this->db->where('device_status', 'Active');
			$query2 = $this->db->get('device');
			
			if ($query2->num_rows() > 0) {
				$device = $query2->row();
				
				if ($device->parent_device != NULL) {
					return $this->device_location($device->parent_device);
				}
			}
			
		}
        
        return $query;
        
    }
    
    function device_table($table_id) {
        
        $this->db->where('computer_table_id', $table_id);
        $query = $this->db->get('computer_table');
        
        return $query->row();
        
    }
	
	function device_details($device_id) {
		
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
				device.device_id = '$device_id'	
		";
		
		$device_query = $this->db->query($sql);
		$device = $device_query->row();
		
		$this->db->where('device_id', $device_id);
		$specs_query = $this->db->get('specification');
		
		$sql = "
			SELECT
				transaction.*,
				transaction_type.transaction_type,
				CONCAT(person_incharge.firstname, ' ', person_incharge.lastname) AS personincharge,
				CONCAT(account.firstname, ' ', account.lastname) AS system_incharge
			FROM
				transaction
			INNER JOIN
				transaction_type
			ON
				transaction.transaction_type_id = transaction_type.transaction_type_id
			INNER JOIN
				person_incharge
			ON
				transaction.person_incharge_id = person_incharge.person_incharge_id
			INNER JOIN
				account
			ON
				transaction.account_id = account.account_id
			WHERE
				transaction.device_id = '$device_id'
		";
		
		$transaction_query = $this->db->query($sql);
		
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
				device.parent_device = '$device_id'	
		";
		
		$devices_inside_query = $this->db->query($sql);
		
		$data = array(
			'device' => $device,
			'specs_query' => $specs_query,
			'transaction_query' => $transaction_query,
			'devices_inside_query' => $devices_inside_query
		);
		
		return $data;
		
	}
	
	
	function get_devicetypes($inner='0') {
		
		if ($inner == '0') {
			$this->db->where('inner_device', '0');
		}
		
		$query = $this->db->get('device_type');
		
		$data = array('' => 'All');
		
		foreach($query->result() as $row) {
			$data[$row->device_type_id] = $row->device_type;
		}
		
		return $data;
		
	}
        
        function edit_device($device_id,$device_name,$specs,$devices,$status='Active') {
            
			$this->load->model('transaction_handler');
			
			$data = array(
				'name' => $device_name,
				'device_status' => $status
			);
			
			$this->db->where('device_id', $device_id);
			$this->db->update('device', $data);
			
            //delete previous specifications
            $this->db->where('device_id', $device_id);
            $this->db->delete('specification');
            //-------------------------------------------------------
            
            //add updated specifications
            $tmp_specs = explode('----', $specs);

            foreach ($tmp_specs as $val) {

                if (trim($val) != '') {

                    $tmp = explode('::::', $val);

                    $data = array(
                        'specification_id' => sha1(uniqid(time())),
                        'device_id' => $device_id,
                        'name' => $tmp[0],
                        'value' => $tmp[1]
                    );

                    $this->db->insert('specification', $data);
                }
            }
            //-------------------------------------------------------
            
            //delete previous devices
            $this->db->where('parent_device', $device_id);
            $this->db->delete('device');
            //-------------------------------------------------------
            
            //add updated devices
            $tmp_devices = explode(',', $devices);

            foreach ($tmp_devices as $val) {

                if (trim($val) != '') {

                    $tmp = explode('::::', $val);

                    $pre_device = $this->transaction_handler->get_predefined_device($tmp[1]);
                    $pre_specs = $this->transaction_handler->get_predevice_specs($tmp[1]);

                    //if ($pre_device != NULL) {
                    $device_tmp = array(
                        'device_id' => md5(uniqid(time())),
                        'device_type_id' => $pre_device->device_type_id,
                        'parent_device' => $device_id,
                        'name' => $pre_device->name,
                        'device_status' => 'Active'
                    );

                    $this->db->insert('device', $device_tmp);

                    foreach ($pre_specs->result() as $row) {

                        $data = array(
                            'specification_id' => sha1(uniqid(time())),
                            'device_id' => $device_id,
                            'name' => $row->name,
                            'value' => $row->value
                        );

                        $this->db->insert('specification', $data);
                    }
                    //}
                }
            }
            //----------------------------------------------------------
            
        }
		
		function delete_device($device_id) {
			
			//delete from workstation
			$this->db->where('device_id', $device_id);
			$this->db->delete('workstation');
			
			
			$data = array(
				'device_status' => 'Deleted'
			);
			
			$this->db->where('device_id', $device_id);
			$this->db->update('device', $data);
			
		}
    
	function search_count($keyword) {
		
		
		if ($keyword == '') {
			return NULL;
		}
		
		$sql = "
			SELECT
				*
			FROM
				specification
			WHERE
				value LIKE '%$keyword' OR
				value LIKE '$keyword%' OR
				value LIKE '%$keyword%'
		";
		
		$query = $this->db->query($sql);
		
		$ids = array();
		
		foreach($query->result() as $row) {
			if (! in_array($row->device_id, $ids)) {
				$ids[] = $row->device_id;
			}
		}
		
		$where = '';
		
		foreach($ids as $id) {
			if ($where == '') {
				$where = "device.device_id = '$id'";
			} else {
				$where .= " OR device.device_id = '$id'";
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
		
		if ($where != '') {
			$sql .= ' WHERE ' . $where;
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->num_rows();
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
					device_type.device_type LIKE '".ucfirst($keyword)."%' OR
					device_type.device_type LIKE '%".ucfirst($keyword)."' OR
					device_type.device_type LIKE '%".ucfirst($keyword)."%'
			";
			
			$query = $this->db->query($sql);
			
			return $query->num_rows();
			
		} else {
			
			
			
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
					device.device_status LIKE '".ucfirst($keyword)."%' OR
					device.device_status LIKE '%".ucfirst($keyword)."' OR
					device.device_status LIKE '%".ucfirst($keyword)."%'
			";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			}
			
		}	
		
		return NULL;
		
	
	}
	
	
	function search($keyword,$offset=0,$limit=40) {
		
		if ($keyword == '') {
			return NULL;
		}
		
		$sql = "
			SELECT
				*
			FROM
				specification
			WHERE
				value LIKE '%$keyword' OR
				value LIKE '$keyword%' OR
				value LIKE '%$keyword%'
		";
		
		$query = $this->db->query($sql);
		
		$ids = array();
		
		foreach($query->result() as $row) {
			if (! in_array($row->device_id, $ids)) {
				$ids[] = $row->device_id;
			}
		}
		
		$where = '';
		
		foreach($ids as $id) {
			if ($where == '') {
				$where = "device.device_id = '$id'";
			} else {
				$where .= " OR device.device_id = '$id'";
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
		
		if ($where != '') {
			$sql .= ' WHERE ' . $where . " LIMIT $offset, $limit";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query;
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
					device_type.device_type LIKE '".ucfirst($keyword)."%' OR
					device_type.device_type LIKE '%".ucfirst($keyword)."' OR
					device_type.device_type LIKE '%".ucfirst($keyword)."%'
				LIMIT $offset, $limit
			";
			
			$query = $this->db->query($sql);
			
			return $query;
			
		} else {
			
			
			
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
					device.device_status LIKE '".ucfirst($keyword)."%' OR
					device.device_status LIKE '%".ucfirst($keyword)."' OR
					device.device_status LIKE '%".ucfirst($keyword)."%'
				LIMIT $offset, $limit
			";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query;
			}
			
		}	
		
		return NULL;
		
	}
	
	function get_device_brand_or_model($device_id) {
		
		$query = $this->db->get_where('specification', array('device_id' => $device_id));
		
		$brand_model = '';
		
		foreach($query->result() as $row) {
			if (strstr('brand', strtolower($row->name))) {
				$brand_model = $row->value;
				break;
			} else if (strstr('model', strtolower($row->name))) {
				$brand_model = $row->value;
				break;
			} else if (strstr('model name', strtolower($row->name))) {
				$brand_model = $row->value;
				break;
			}
		}
		
		return $brand_model;
		
	}
	
}

/* End of file device_handler.php */
/* Location: ./application/models/device_handler.php */