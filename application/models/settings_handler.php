<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings_handler extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add_specs($predefined_device_id, $spec_name, $spec_value) {

        $data = array(
            'predefined_specs_id' => md5(uniqid(sha1(time()))),
            'predefined_device_id' => $predefined_device_id,
            'name' => $spec_name,
            'value' => $spec_value
        );

        $this->db->insert('predefined_specs', $data);
    }

    function add_device($device_name, $device_type, $devices_inside='') {

        $data = array(
            'device_type_id' => $device_type,
            'name' => $device_name,
            'predefined_device_id' => md5(uniqid(sha1(time()))),
            'devices_inside' => $devices_inside
        );

        $query = $this->db->insert('predefined_device', $data);

        return $data['predefined_device_id'];
    }

    function getPredefinedDevices() {

        $sql = "
            SELECT
                dt.device_type,
                pd.*
            FROM
                predefined_device AS pd
            INNER JOIN
                device_type AS dt
            ON
                pd.device_type_id = dt.device_type_id
        ";

        $query = $this->db->query($sql);

        return $query;
    }

    function predefined_device_exists($device_id) {

        $this->db->where('predefined_device_id', $device_id);
        $query = $this->db->get('predefined_device');

        if ($query->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    function get_predefined_device_info($device_id) {

        $sql = "
            SELECT
                predefined_device.*,
                device_type.device_type
            FROM
                predefined_device
            INNER JOIN
                device_type
            ON
                predefined_device.device_type_id = device_type.device_type_id
            WHERE
                predefined_device.predefined_device_id = '$device_id'
        ";

        $query = $this->db->query($sql);

        return $query->row();
    }

    function get_predefined_device_specs($device_id) {

        $this->db->where('predefined_device_id', $device_id);
        $query = $this->db->get('predefined_specs');

        return $query;
    }

    function update_pre_device($device_id, $device_name, $device_type, $specs, $devices_inside='') {

        $data = array(
            'device_type_id' => $device_type,
            'name' => $device_name,
            'devices_inside' => $devices_inside
        );

        $this->db->where('predefined_device_id', $device_id);
        $this->db->update('predefined_device', $data);


        $this->db->where('predefined_device_id', $device_id);
        $this->db->delete('predefined_specs');

        foreach ($specs as $name => $value) {
            $this->add_specs($device_id, $name, $value);
        }
    }

    function delete_predefined_device($device_id) {

        $this->db->where('predefined_device_id', $device_id);
        $this->db->delete('predefined_device');
    }

    function locations() {

        $sql = "
            SELECT
                location.*,
                computer_table.name AS table_name,
                computer_table.num_workstation
            FROM
                location
            LEFT JOIN
                computer_table
            ON
                location.location_id = computer_table.location_id
            GROUP BY
                location.location_id
        ";

        $query = $this->db->query($sql);

        return $query;
    }

    function add_location($location_name, $num_computer_table, $num_workstation) {

        $location_data = array(
            'location' => $location_name,
            'num_table' => $num_computer_table
        );

        $this->db->insert('location', $location_data);

        $location_id = $this->db->insert_id();

        for ($x = 1; $x <= $num_computer_table; $x++) {

            $computer_table_data = array(
                'location_id' => $location_id,
                'name' => $x,
                'num_workstation' => $num_workstation
            );

            $this->db->insert('computer_table', $computer_table_data);

        }
    }

    function edit_location($location_id, $location_name, $num_computer_table, $num_workstation) {

        $location_data = array(
            'location' => $location_name,
            'num_table' => $num_computer_table
        );

        $this->db->where('location_id', $location_id);
        $this->db->update('location', $location_data);


        $computer_table_data = array(
            'location_id' => $location_id,
            'name' => $x,
            'num_workstation' => $num_workstation
        );

        $this->db->where('location_id', $location_id);
        $this->db->update('computer_table', $computer_table_data);

        $this->db->where('location_id', $location_id);
        $query = $this->db->get('computer_table');

        if ($query->num_rows() >= $num_computer_table) {
            $num_c = $query->num_rows() - $num_computer_table;

            for ($x = 0; $x < $num_c; $x++) {

                $this->db->where('location_id', $location_id);
                $this->db->where('name', $query->num_rows() - $x);
                $this->db->delete('computer_table');
            }
        } else {

            $num_c = $num_computer_table - $query->num_rows();

            for ($x = 0; $x < $num_c; $x++) {

                $this->db->insert('computer_table', $computer_table_data);
            }
        }
    }

    function get_location_info($location_id) {

        $sql = "
            SELECT
                location.*,
                computer_table.name AS table_name,
                computer_table.num_workstation
            FROM
                location
            LEFT JOIN
                computer_table
            ON
                location.location_id = computer_table.location_id
            WHERE
                location.location_id = '$location_id'
            GROUP BY
                location.location_id
        ";

        $query = $this->db->query($sql);

        return $query->row();
    }

    function is_valid_location($location_id) {

        $this->db->where('location_id', $location_id);
        $query = $this->db->get('location');

        if ($query->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    function delete_location($location_id) {

        $this->db->where('location_id', $location_id);
        $this->db->delete('location');
    }

    function get_device_types() {

        $query = $this->db->get('device_type');

        return $query;
    }

    function get_device_type($device_type_id) {

        $this->db->where('device_type_id', $device_type_id);
        $query = $this->db->get('device_type');

        return $query->row();
    }

    function get_devicetypes($device_id) {

        $this->db->where('predefined_device_id', $device_id);
        $query = $this->db->get('predefined_device');

        $devices = $query->row()->devices_inside;

        $temp = explode(',', $devices);
        $where = '';

        foreach ($temp as $key => $row) {
            if ($where == '') {
                $where = 'device_type_id = \'' . $row . '\'';
            } else {
                $where .= 'OR device_type_id = \'' . $row . '\'';
            }
        }

        $sql = "
            SELECT
                *
            FROM
                device_type
        ";

        if ($where != '') {

            $sql .= ' WHERE ' . $where;

            $query = $this->db->query($sql);

            return $query;
        }

        return NULL;
    }

    function add_device_type($device_type,$inner=0,$with_devices=0) {

        $data = array(
            'device_type' => $device_type,
			'inner_device' => $inner,
			'with_devices' => $with_devices
        );

        $this->db->insert('device_type', $data);
    }

    function delete_device_type($device_type_id) {

        $this->db->where('device_type_id', $device_type_id);
        $this->db->delete('predefined_device');

        $this->db->where('device_type_id', $device_type_id);
        $this->db->delete('device');

        $this->db->where('device_type_id', $device_type_id);
        $this->db->delete('device_type');
    }

    function edit_device_type($device_type_id, $device_type, $inner, $with_devices) {

        $data = array(
            'device_type' => $device_type,
			'inner_device' => $inner,
			'with_devices' => $with_devices
        );

        $this->db->where('device_type_id', $device_type_id);
        $this->db->update('device_type', $data);
    }
    
    function num_workstation_in($location_id) {
        
        $sql = "
            SELECT
                workstation.*
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
                location.location_id = '$location_id'
            GROUP BY
                workstation.name, workstation.computer_table_id
        ";
        
        $query = $this->db->query($sql);
        
        return $query->num_rows();
        
    }

}

/* End of file settings_handler.php */
/* Location: ./application/models/settings_handler.php */