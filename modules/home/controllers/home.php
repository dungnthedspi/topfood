<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	private $model_name;

	function __construct() {
		parent::__construct();
		$this->model_name = "home";
		$this->load->model('home_model', $this->model_name);
		$this->load->library('googlemaps');
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

	function map2() {
		$post=$this->input->post();
		$restaurants = $this->home->getlocationRestaurants();

		$this->load->library('googlemaps');
		$config['center'] = 'auto';
		$config['zoom'] = '13';
		$config['map_height'] = '580px';
		$this->googlemaps->initialize($config);

		$marker = array();
		$marker['position'] = $post['lat'].', '.$post['lng'];
		$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
		$marker['title']= 'your location';
		$this->googlemaps->add_marker($marker);

		for ($i=0; $i < count($restaurants); $i++) {
			$latlng = explode(",", $restaurants[$i]->location);

			$miles = (sin(deg2rad($post['lat'])) * sin(deg2rad($latlng[0]))) + (cos(deg2rad($post['lat'])) * cos(deg2rad($latlng[0])) * cos(deg2rad($post['lng'] - $latlng[1])));
			$miles = acos($miles);
	    	$miles = rad2deg($miles);
	    	$miles = $miles * 60 * 1.1515;
	    	$kilometers = $miles * 1.609344;
	    	if($kilometers <= 3) {
	    		$marker = array();
				$marker['position'] = $restaurants[$i]->location;
				$marker['infowindow_content'] = $restaurants[$i]->account_name;
				$this->googlemaps->add_marker($marker);
	    	}
		}

		$data['map'] = $this->googlemaps->create_map();
		$this->load->view('homes/map1', $data);
	}

	function map() {
		$this->load->library('googlemaps');

		$restaurants = $this->home->getlocationRestaurants();

		$config['center'] = '21.019547, 105.8235032';
		$config['zoom'] = '13';
		$config['map_height'] = '580px';
		$this->googlemaps->initialize($config);

		foreach ($restaurants as $r) {
			$marker = array();
			$marker['position'] = $r->location;
			$marker['infowindow_content'] = $r->account_name;
			$this->googlemaps->add_marker($marker);
		}

		$data = array(
			'restaurants' => $restaurants,
			'map' => $this->googlemaps->create_map(),
		);

		$this->load->view('homes/map', $data);
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