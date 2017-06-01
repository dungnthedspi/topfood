<?php

class MY_Controller extends CI_Controller {
	protected $_login_data;

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->_init();
		$this->_login_data = $this->session->userdata("LogInData");
	}

	private function _init() {
		$this->output->set_template('default');
		$this->output->set_title("Topfood");

		$this->load->section('header', "themes/default/header");
		$this->load->section('right_bar', "themes/default/right_bar");
		$this->load->section('footer', "themes/default/footer");
	}

	function logged_in() {
		return ($this->session->userdata("LogInData")) ? true : false;
	}

}