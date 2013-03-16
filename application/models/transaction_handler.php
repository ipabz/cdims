<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction_handler extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getTransactionTypes() {

        $query = $this->db->get('transaction_type');

        $data = array('' => '[ Select One ]');

        foreach ($query->result() as $row) {
            $data[$row->transaction_type_id] = ucwords($row->transaction_type);
        }

        return $data;
    }

    function getDeviceCategories() {

        $query = $this->db->get('device_type');

        $data = array('' => '[ Select One ]');

        foreach ($query->result() as $row) {
            $data[$row->device_type_id] = $row->device_type;
        }

        return $data;
    }

    function getLocations() {

        $query = $this->db->get('location');

        $data = array('' => '[ Select One ]');

        foreach ($query->result() as $row) {
            $data[$row->location_id] = $row->location;
        }

        return $data;
    }

    function get_inputs($device_type) {

        $this->db->where('device_type_id', $device_type);
        $query = $this->db->get('predefined_device');

        $inputs = array();

        $where = '';

        foreach ($query->result() as $row) {

            if ($where == '') {
                $where = ' predefined_device_id = \'' . $row->predefined_device_id . '\'';
            } else {
                $where .= ' OR predefined_device_id = \'' . $row->predefined_device_id . '\'';
            }
        }

        $sql = '
            SELECT
                DISTINCT name
            FROM
                predefined_specs
            WHERE
        ';

        if ($where != '') {

            $sql .= $where;

            $query = $this->db->query($sql);

            return $query;
        }

        return NULL;
    }
    
    
    function possible_values($name, $device_type) {

        $this->db->where('device_type_id', $device_type);
        $query = $this->db->get('predefined_device');

        $where = '';

        foreach ($query->result() as $row) {
            if ($where == '') {
                $where = ' predefined_device_id = "' . $row->predefined_device_id . '"';
            } else {
                $where .= ' OR predefined_device_id = "' . $row->predefined_device_id . '"';
            }
        }

        $sql = "
            SELECT
                *
            FROM
                predefined_specs
            WHERE
                name = '$name'
        ";

        if ($where != '') {
            $sql .= ' AND (' . $where . ')';
        }

        $query = $this->db->query($sql);

        $data = array(
            '' => ' [ Select one ] '
        );

        foreach ($query->result() as $row) {
            $data[$row->value] = $row->value;
        }


		$data2 = $this->possible_values_p2($name, $device_type);
		
		$data = array_merge($data, $data2);
		$data = array_unique($data);

        return $data;
    }
	
	function possible_values_p2($name, $device_type) {
		
		$this->db->where('device_type_id', $device_type);
        $query = $this->db->get('device');

        $where = '';

        foreach ($query->result() as $row) {
            if ($where == '') {
                $where = ' device_id = "' . $row->device_id . '"';
            } else {
                $where .= ' OR device_id = "' . $row->device_id . '"';
            }
        }

        $sql = "
            SELECT
                *
            FROM
                specification
            WHERE
                name = '$name'
        ";

        if ($where != '') {
            $sql .= ' AND (' . $where . ')';
        }

        $query = $this->db->query($sql);

        $data = array();

        foreach ($query->result() as $row) {
            $data[$row->value] = $row->value;
        }

        return $data;
		
	}

    function get_devices($device_id) {

        $this->db->where('predefined_device_id', $device_id);
        $query = $this->db->get('predefined_device');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $devices = explode(',', $row->devices_inside);

            $where = '';

            foreach ($devices as $device) {

                if ($where == '') {
                    $where = ' device_type_id = \'' . $device . '\'';
                } else {
                    $where .= ' OR device_type_id = \'' . $device . '\'';
                }
            }

            $sql = '
                SELECT
                    *
                FROM
                    device_type
                WHERE
            ';

            if ($where != '') {

                $sql .= $where;

                $query = $this->db->query($sql);

                $data = array(
                    '' => ' [ Select one ] '
                );

                foreach ($query->result() as $row) {
                    $data[$row->device_type_id] = $row->device_type;
                }

                return $data;
            }
        }

        return NULL;
    }

    function no_choices($spec_name) {

        $data = array(
            'serial',
			'Serial Number (system)'
        );

        return in_array($spec_name, $data);
    }

    function devices_inside($device_type) {

        $this->db->where('device_type_id', $device_type);
        $query = $this->db->get('predefined_device');

        $current_dev = '';

        foreach ($query->result() as $row) {
            if (strlen($row->devices_inside) > strlen($current_dev)) {
                $current_dev = $row->devices_inside;
            }
        }

        return explode(',', $current_dev);
    }

    function get_device_type($device_type_id) {

        $this->db->where('device_type_id', $device_type_id);
        $query = $this->db->get('device_type');

        return $query->row();
    }

    function get_predevices_of_type($device_type) {

        $this->db->where('device_type_id', $device_type);
        $query = $this->db->get('predefined_device');

        return $query;
    }

    function person_incharge() {

        $query = $this->db->get('person_incharge');

        return $query;
    }

    function getLocation($location_id) {

        $this->db->where('location_id', $location_id);

        return $this->db->get('location');
    }

    function getComputerTables_in($location_id) {

        $this->db->where('location_id', $location_id);

        return $this->db->get('computer_table');
    }

    function getAvailableWorstation_in($computer_table) {

        $this->db->where('computer_table_id', $computer_table);
        $query_computer_table = $this->db->get('computer_table');

        $this->db->where('computer_table_id', $computer_table);
        $query = $this->db->get('workstation');

        $workstations = array();
        $row = $query_computer_table->row();

        for ($x = 1; $x <= $row->num_workstation; $x++) {
            $workstations[$x] = $x;
        }

        $temp = array();

        foreach ($query->result() as $row2) {

            if (in_array($row2->name, $workstations)) {
                //unset($workstations[$row2->name]);
            }
        }

        return $workstations;
    }

    function get_person_incharge($id_number) {

        $this->db->where('person_incharge_id', $id_number);
        $query = $this->db->get('person_incharge');

        return $query->row();
    }

    //add a new transaction. new device
    function add_transaction($transaction_type, $device_name, $device_type, $option, $specs, $devices, $location, $table, $workstation, $fname, $lname, $contact_number, $id_number, $more_info = '') {

        //-------------------------------------------
        $device_data = array(
            'device_id' => md5(uniqid(time())),
            'device_type_id' => $device_type,
            'name' => $device_name,
            'device_status' => 'Active'
        );

        $this->db->insert('device', $device_data);
        //-------------------------------------------
        //-------------------------------------------
        $tmp_specs = explode('----', $specs);

        foreach ($tmp_specs as $val) {

            if (trim($val) != '') {

                $tmp = explode('::::', $val);

                $data = array(
                    'specification_id' => sha1(uniqid(time())),
                    'device_id' => $device_data['device_id'],
                    'name' => $tmp[0],
                    'value' => $tmp[1]
                );

                $this->db->insert('specification', $data);
            }
        }
        //-------------------------------------------
        //-------------------------------------------  

        if (!$this->person_incharge_exists($id_number)) {

            $person_incharge_data = array(
                'person_incharge_id' => $id_number,
                'firstname' => $fname,
                'lastname' => $lname,
                'contact_number' => $contact_number
            );
            //print_r($person_incharge_data);
            @$this->db->insert('person_incharge', $person_incharge_data);
        }

        //-------------------------------------------
        //-------------------------------------------
        $transaction_data = array(
            'transaction_id' => sha1(uniqid(time())),
            'device_id' => $device_data['device_id'],
            'person_incharge_id' => $id_number,
            'account_id' => $this->session->userdata('id_number'),
            'transaction_type_id' => $transaction_type,
            'more_info' => $more_info,
            'transaction_date' => date('Y-m-d H:i:s')
        );

        $this->db->insert('transaction', $transaction_data);
        //-------------------------------------------
        //-------------------------------------------
        $location_data = array(
            'device_id' => $device_data['device_id'],
            'computer_table_id' => $table,
            'name' => $workstation,
			'location_id' => $location
        );

        $this->db->insert('workstation', $location_data);
        //-------------------------------------------
        //-------------------------------------------

        $tmp_devices = explode(',', $devices);

        foreach ($tmp_devices as $val) {

            if (trim($val) != '') {

                $tmp = explode('::::', $val);

                $pre_device = $this->get_predefined_device($tmp[1]);
                $pre_specs = $this->get_predevice_specs($tmp[1]);

                //if ($pre_device != NULL) {
                $device_tmp = array(
                    'device_id' => md5(uniqid(time())),
                    'device_type_id' => $pre_device->device_type_id,
                    'parent_device' => $device_data['device_id'],
                    'name' => $pre_device->name,
                    'device_status' => 'Active'
                );

                $this->db->insert('device', $device_tmp);

                foreach ($pre_specs->result() as $row) {

                    $data = array(
                        'specification_id' => sha1(uniqid(time())),
                        'device_id' => $device_tmp['device_id'],
                        'name' => $row->name,
                        'value' => $row->value
                    );

                    $this->db->insert('specification', $data);
                }
                //}
            }
        }
        //-------------------------------------------
    }

    function person_incharge_exists($id_number) {

        $this->db->where('person_incharge_id', $id_number);
        $query = $this->db->get('person_incharge');

        if ($query->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    function get_predefined_device($device_id) {

        $this->db->where('predefined_device_id', $device_id);
        $query = $this->db->get('predefined_device');

        if ($query->num_rows() == 0) {
            return NULL;
        }

        return @$query->row();
    }

    function get_predevice_specs($device_id) {

        $this->db->where('predefined_device_id', $device_id);
        $query = $this->db->get('predefined_specs');

        return $query;
    }
    
    function search($device_type, $spec, $keyword) {
        
        $devices_query = $this->db-get_where('predefined_device', array('device_type_id'=>$device_type));
        
        $where = '';
        
        foreach($devices_query->result() as $row) {
            if($where == '') {
                $where = 'predefined_device_id = \''.$row->predefined_device_id.'\'';
            } else {
                $where .= ' OR predefined_device_id = \''.$row->predefined_device_id.'\'';
            }
        }
        
        $sql = "
            SELECT
                *
            FROM
                predefined_specs
            WHERE
                name = '$spec' AND
                value LIKE '%keyword%'
        ";
        
        if ($where != '') {
            $sql .= ' AND ('.$where.')';
        }
        
        $query_specs = $this->db->query($sql);
        
        $where = '';
        
        foreach($query_specs->result() as $row) {
            if($where == '') {
                $where = 'predefined_device_id = \''.$row->predefined_device_id.'\'';
            } else {
                $where .= ' OR predefined_device_id = \''.$row->predefined_device_id.'\'';
            }
        }
        
        $sql = "
            SELECT
                *
            FROM
                predefined_device
            WHERE
        ";
        
        $sql .= ' '.$where;
        
        $query = $this->db->query($sql);
        
        return $query;
    
    }
	
	function devices_in($location,$table,$workstation) {
		
		$sql = "
			SELECT
				workstation.device_id
			FROM
				workstation
			INNER JOIN
				computer_table
			ON
				workstation.computer_table_id = computer_table.computer_table_id
			WHERE
				computer_table.computer_table_id = '$table' AND
				workstation.name = '$workstation'
		";
		
		$query = $this->db->query($sql);
		
		$devices_ids = array();
		
		foreach($query->result() as $row) {
			
			$devices_ids[] = $row->device_id;
			
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
				device.device_status = 'Active' AND
		";
		
		$where = "";
		
		foreach($devices_ids as $row) {
			if ($where == "") {
				$where = " device.device_id = '$row'";
			} else {
				$where .= " OR device.device_id = '$row'";
			}
		}
		
		if (count($devices_ids) > 0) {
			
			$query = $this->db->query($sql.$where);
			
			return $query;
			
		}
		
		return NULL;
		
	}
	
	/*
	* $devices = array() -- array of device ids
	* $person_incharge = array(
	*	'id_number',
	*	'firstname',
	*	'lastname',
	*	'contact_number'
	)
	*/
	function stockout_add_transaction($transaction_type,$devices,$person_incharge,$more_info) {
		
		if (! $this->person_incharge_exists($person_incharge['id_number'])) {
			$person_incharge_data = array(
                'person_incharge_id' => $person_incharge['id_number'],
                'firstname' => $person_incharge['firstname'],
                'lastname' => $person_incharge['lastname'],
                'contact_number' => $person_incharge['contact_number']
            );
            
            $this->db->insert('person_incharge', $person_incharge_data);
		}
		
		foreach($devices as $device) {
			
			$transaction_data = array(
				'transaction_id' => sha1(uniqid(time())),
				'device_id' => $device,
				'person_incharge_id' => $person_incharge['id_number'],
				'account_id' => $this->session->userdata('id_number'),
				'transaction_type_id' => $transaction_type,
				'more_info' => $more_info,
				'transaction_date' => date('Y-m-d H:i:s')
			);
	
			$this->db->insert('transaction', $transaction_data);
			
			//delete from workstation
			$this->db->where('device_id', $device);
			$this->db->delete('workstation');
			
			$device_data = array(
				'device_status' => 'Inactive'
			);
			
			$this->db->where('device_id', $device);
			$this->db->update('device', $device_data);
			
		}
		
	}
	
	function transaction_lists($offset=0,$limit=20,$start_date='',$end_date='',$transaction_type='') {
		
		$sql = "
			SELECT
				transaction.*,
				transaction_type.transaction_type,
				device.name,
				device.device_type_id,
				person_incharge.firstname,
				person_incharge.lastname,
				account.firstname AS afn,
				account.lastname AS aln
			FROM
				transaction
			INNER JOIN
				device
			ON
				transaction.device_id = device.device_id
			INNER JOIN
				person_incharge
			ON
				transaction.person_incharge_id = person_incharge.person_incharge_id
			INNER JOIN
				transaction_type
			ON
				transaction.transaction_type_id = transaction_type.transaction_type_id
			INNER JOIN
				account
			ON
				transaction.account_id = account.account_id
		";
		
		if ($start_date != '' && $end_date != '') {
		
			$sql .= "		
				WHERE
					DATE_FORMAT(transaction.transaction_date, '%Y-%m-%d') >= DATE_FORMAT('$start_date', '%Y-%m-%d') AND
					DATE_FORMAT(transaction.transaction_date, '%Y-%m-%d') <= DATE_FORMAT('$end_date', '%Y-%m-%d')
			";
		
		}
		
		if ($start_date != '' && $end_date != '' && $transaction_type != '') {
			
			$sql .= "
					AND transaction.transaction_type_id = '$transaction_type'
			";
			
		} else if ($start_date == '' && $end_date == '' && $transaction_type != '') {
			
			$sql .= "
					WHERE
						transaction.transaction_type_id = '$transaction_type'
			";
			
		}
		
		$sql .= "
			ORDER BY
				transaction.transaction_date DESC
			LIMIT $offset, $limit			
		"; 
		
		$query = $this->db->query($sql);
		
		return $query;
		
	}
	
	
	function count_all_transactions($start_date='',$end_date='',$transaction_type='') {
		
		$sql = "
			SELECT
				transaction.*,
				transaction_type.transaction_type,
				device.name,
				person_incharge.firstname,
				person_incharge.lastname,
				account.firstname AS afn,
				account.lastname AS aln
			FROM
				transaction
			INNER JOIN
				device
			ON
				transaction.device_id = device.device_id
			INNER JOIN
				person_incharge
			ON
				transaction.person_incharge_id = person_incharge.person_incharge_id
			INNER JOIN
				transaction_type
			ON
				transaction.transaction_type_id = transaction_type.transaction_type_id
			INNER JOIN
				account
			ON
				transaction.account_id = account.account_id
		";
		
		if ($start_date != '' && $end_date != '') {
		
			$sql .= "		
				WHERE
					DATE_FORMAT(transaction.transaction_date, '%Y-%m-%d') >= DATE_FORMAT('$start_date', '%Y-%m-%d') AND
					DATE_FORMAT(transaction.transaction_date, '%Y-%m-%d') <= DATE_FORMAT('$end_date', '%Y-%m-%d')
			";
		
		}
		
		if ($start_date != '' && $end_date != '' && $transaction_type != '') {
			
			$sql .= "
					AND transaction.transaction_type_id = '$transaction_type'
			";
			
		} else if ($start_date == '' && $end_date == '' && $transaction_type != '') {
			
			$sql .= "
					WHERE
						transaction.transaction_type_id = '$transaction_type'
			";
			
		}
		
		$sql .= "
			ORDER BY
				transaction.transaction_date DESC
		"; 
		
		$query = $this->db->query($sql);
		
		return $query->num_rows();
		
	}
	
	function has_duplicate($device_type,$workstation,$table) {
		
		$this->db->where('name', $workstation);
		$this->db->where('computer_table_id', $table);
		$query = $this->db->get('workstation');
		
		$devices_ids = array();
		
		foreach($query->result() as $row) {
			$devices_ids[] = $row->device_id;
		}
		
		$where = '';
		
		foreach($devices_ids as $id) {
			if ($where == '') {
				$where = "device_id = '$id'";
			} else {
				$where .= " OR device_id = '$id'";	
			}
		}
		
		if ($where != '') {
			$where = ' AND ( '. $where . ' )';
		} else {
			return FALSE;	
		}
		
		$sql = "
			SELECT
				*
			FROM
				device
			WHERE
				device_type_id = '$device_type' 
		".$where;
		
		$query = $this->db->query($sql);
		
		return ($query->num_rows() > 0) ? TRUE : FALSE;
		
	}
	
	function existing_devices() {
		
		$this->db->select('device.*, device_type.device_type');
		$this->db->from('device');
		$this->db->join('device_type', 'device.device_type_id = device_type.device_type_id', 'inner');
		$this->db->where('device_status', 'Inactive');
		$query = $this->db->get();
		
		return $query;
		
	}
	
	function getdevice($device_id) {
		
		$this->db->where('device_id', $device_id);
		$query = $this->db->get('device');
		
		return $query->row();
		
	}
	
	
	function add_transaction_existing($transaction_type, $device_id, $location, $table, $workstation, $fname, $lname, $contact_number, $id_number, $more_info = '') {

		$d_data = array('device_status' => 'Active');
		$this->db->where('device_id', $device_id);
		$this->db->update('device', $d_data);
		
		$data = array(
			'device_id' => $device_id,
			'computer_table_id' => $table,
			'name' => $workstation,
			'location_id' => $location
		);
		
		$this->db->insert('workstation', $data);
		
		if (!$this->person_incharge_exists($id_number)) {

            $person_incharge_data = array(
                'person_incharge_id' => $id_number,
                'firstname' => $fname,
                'lastname' => $lname,
                'contact_number' => $contact_number
            );
            //print_r($person_incharge_data);
            @$this->db->insert('person_incharge', $person_incharge_data);
        }
		
		$transaction_data = array(
            'transaction_id' => sha1(uniqid(time())),
            'device_id' => $device_id,
            'person_incharge_id' => $id_number,
            'account_id' => $this->session->userdata('id_number'),
            'transaction_type_id' => $transaction_type,
            'more_info' => $more_info,
            'transaction_date' => date('Y-m-d H:i:s')
        );

        $this->db->insert('transaction', $transaction_data);
		
	}

}

/* End of file transaction_handler.php */
/* Location: ./application/models/transaction_handler.php */