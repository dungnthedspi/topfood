<?php

class Auth_Model extends CI_Model {

	function __construct() {
		parent::__construct();

	}

	function logIn($params = array()) {
		if (isset($params['username']) && isset($params['password'])) {
			$this->db->trans_start();
			$query = $this->db->get_where(
				'user',
				array(
					'username' => $params['username'],
					'password' => $params['password']
				)
			);
			$this->db->trans_complete();
			return $query->result();
		}
		return false;
	}

	function getUserInfo($userId) {

		$sql = "SELECT `user`.*, account.account_id, account.account_name, customer.customer_id FROM `user` 
            LEFT JOIN account ON `user`.id = account.user_id
            LEFT JOIN customer ON `user`.id = customer.user_id
            WHERE
            `user`.id = " . $userId . "
            AND `user`.`status` = 1";

		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();

		return $query->row();
	}
}