<?php

class Home extends MY_Controller {
	private $model_name;

	function __construct() {
		parent::__construct();
		$this->model_name = "home";
		$this->load->model('home_model', $this->model_name);
	}

	function index() {
		$this->output->append_title('Home page');
		$data = array(
			'title' => 'Title goes here',
			'body' => 'The string to be embedded here!'

		);
		$restaurants = $this->home->getRestaurants();
		$areas = $this->home->getAreas();
//		debug($this->db->last_query());
		$data = array(
			'restaurants' => $restaurants,
			'areas' => $areas
		);
		$this->load->view("homes/index", $data);
	}

	function search() {
		$area_id = $this->input->get();
		$restaurants = $this->home->getAcountsByAreaId($area_id);
		$areas = $this->home->getAreas();
		$data = array(
			'restaurants' => $restaurants,
			'areas' => $areas,
			'selected_id' => $area_id
		);
		$this->load->view("homes/search", $data);
	}

	function test() {
		$data = "default data";
		$agrs = func_get_args();
		if (count($agrs)) {
			$data = ($agrs[0]['data']);
		}
		$this->load->view("homes/test", array('data' => $data));
	}
}