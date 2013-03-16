<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller {
	
	function __construct() {
		parent::__construct();	
		$this->load->model('device_handler');
		$this->load->model('transaction_handler');
	}
	
	function index($keyword='',$page=0) {
		$head = array(
            'title' => 'Search'
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
			'title' => 'Search'
		);
		
		$this->pagination->initialize($config); 
		
        $this->load->view('html_head', $head);
        $this->load->view('header');
        $this->load->view('search/results', @$data);
        $this->load->view('footer');
	}
	
}

?>