<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_Controller {
	
	function __construct() {
		parent::__construct();	
		$this->load->model('report_handler');
	}
	
	function graphical() {
		$head = array(
			'title' => 'Graphical Report'
		);
		$this->load->view('html_head', $head);
        $this->load->view('header');
		$this->load->view('report/graphical');	
        $this->load->view('footer');
	}
	
	function tabular($offset=0) {
		
		$this->load->model('transaction_handler');
		$this->load->model('device_handler');
		
		$specs = array(''=> 'All');
		$values[''] = 'All';
		
		$device_type = $this->input->post('device-type');
		
		$query = NULL;
		
		$per_page = 20;
		
		if ($this->input->post('generate-report')) {
			
			$specs_query = $this->transaction_handler->get_inputs($device_type);
			
			
			if ($specs_query != NULL) {
				
				foreach($specs_query->result() as $row) {
					$specs[$row->name] = $row->name;
				}
				
			}
			
			$spec_name = $this->input->post('specification-name');
			
			if ($spec_name != '') {
				
				$values = $this->transaction_handler->possible_values($spec_name,$device_type);
				$values[''] = 'All';
				
			}
			
			
			//generate report
			$query = $this->report_handler->tabular_generate_report($offset, $per_page, $this->input->post('location'), $this->input->post('device-type'), $this->input->post('specification-name'), $this->input->post('specification-value'));
			
		}
		
		
		$head = array(
			'title' => 'Tabular Report'
		);
		
		$locations = $this->transaction_handler->getLocations();
		$locations[''] = 'All';
		
		$data = array(
			'locations' => $locations,
			'device_types' => $this->device_handler->get_devicetypes(1),
			'spec_names' => $specs,
			'spec_values' => $values,
			'report_query' => $query
		);
		
		$this->load->view('html_head', $head);
        $this->load->view('header');
        $this->load->view('report/tabular/list', $data);
        $this->load->view('footer');
		
	}
	
	function specs_name() {
		
		$device_type = $this->input->post('device-type');
		$specs = array('' => 'All');
		
		if ($device_type != '') {
			
			$this->load->model('transaction_handler');
			
			$specs_query = $this->transaction_handler->get_inputs($device_type);
			
			
			if ($specs_query != NULL) {
				
				foreach($specs_query->result() as $row) {
					$specs[$row->name] = $row->name;
				}
				
			}
			
			print form_dropdown('specification-name', $specs, set_value('specification-name'), 'onchange="report.get_specvalues(\''.site_url('report/spec_values').'\', this.value)"').nbs(3);
			
		} else {
			print form_dropdown('specification-name', $specs, set_value('specification-name'), 'disabled="disabled"').nbs(3);
		}
		
	}
	
	function spec_values() {
		
		$spec_name = $this->input->post('spec-name');
		$device_type = $this->input->post('device-type');
		
		if ($spec_name != '') {
			
			$this->load->model('transaction_handler');
			
			$values = $this->transaction_handler->possible_values($spec_name,$device_type);
			$values[''] = 'All';
			
			print form_dropdown('specification-value', $values, set_value('specification-value'));
			
		}
		
	}
	
	function to_pdf() {
		
		require('fpdf17/fpdf.php');
		require('fpdf17/pdf.php');
		
		@unlink('my-pdf.pdf');
		
		$pdf = new PDF();
		// Column headings
		$pdf->title = $this->input->post('title');
		
		$header = array('#', 'Device Type', 'Brand or Model', 'Location', 'Computer Table', 'Workstation');
		// Data loading
		//$data = $pdf->LoadData('countries.txt');
		//$pdf->SetFont('Arial','',14);
		//$pdf->AddPage();
		//$pdf->BasicTable($header,$data);
		//$pdf->AddPage();
		//$pdf->ImprovedTableHeader($header,$data);
		//$pdf->AddPage();
		//$pdf->FancyTable($header,$data);
		
		$this->load->model('transaction_handler');
		$this->load->model('device_handler');
		
		//generate report
		$query = $this->report_handler->tabular_generate_report(@$offset, @$per_page, $this->input->post('location'), $this->input->post('devicetype'), $this->input->post('spn'), $this->input->post('spv'));
		
		$counter = 1;
		
		
		
		//print $this->input->post('spn').' - '.$this->input->post('spv');
		$datas = array();
		
		foreach($query->result() as $row) {
			
			$data = array();
			
			$data[] = $counter;
			
			$data[] = $row->device_type;
			$data[] = $this->device_handler->get_device_brand_or_model($row->device_id);
			
			$loc = $this->device_handler->device_location($row->device_id);
			$data[] = @$loc->row()->location;
			$data[] = @$this->device_handler->device_table($loc->row()->computer_table_id)->name;
			$data[] = @$loc->row()->name;
			
			$datas[] = $data;
			$counter++;
			
		}
		
		$pdf->AddPage();
		$pdf->ImprovedTableHeader($header,$datas);
		
		
		$pdf->Output('my-pdf.pdf');
				
		
		
	}
	
}

/* End of file report.php */
/* Location: ./application/controllers/report.php */