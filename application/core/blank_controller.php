<?php

class Blank_Controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->_init();
	}

	private function _init() {
		$this->output->set_template('blank');
		$this->output->set_title("Topfood");
	}
}