<?php

/**
 * Created by PhpStorm.
 * User: Dinh_Quyet
 * Date: 5/5/2017
 * Time: 03:30
 */
class Home_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getRestaurants() {
		$this->db->select('acc.*, us.avatar, us.address, us.phone,
         (SUM(aaa.vote_price)/COUNT(aaa.account_id)) vote_price,
         (SUM(aaa.vote_service)/COUNT(aaa.account_id)) vote_service,
         (SUM(aaa.vote_quality)/COUNT(aaa.account_id)) vote_quality,
         (SUM(aaa.vote_space)/COUNT(aaa.account_id)) vote_space,
         (SUM(aaa.vote_location)/COUNT(aaa.account_id)) vote_location,
          email, COUNT(aaa.account_id) num_comment');
		$this->db->from('account acc');
		$this->db->join('account_article_author aaa', 'acc.account_id=aaa.account_id', 'left');
		$this->db->join('user us', 'us.id=acc.user_id', 'left');

		$this->db->where(array('us.status' => '1', "role" => 2));
		$this->db->group_by('acc.account_id', 'DESC');
		$this->db->order_by('vote_price', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getlocationRestaurants() {
		$this->db->select('acc.location, acc.account_name, us.avatar');
		$this->db->from('account acc');
		$this->db->join('user us', 'us.id=acc.user_id', 'left');

		$this->db->where(array('us.status' => '1', "role" => 2));
		$this->db->group_by('acc.account_id', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCustomers() {
		$this->db->select('us.address');
		$this->db->from('user us');

		$this->db->where(array('us.status' => '1', "role" => 3));
		$query = $this->db->get();
		if ($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAreas() {
		$sql = "SELECT * FROM area where status = 1";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getAcountsByAreaId($area_id) {
		$this->db->select('acc.*, us.avatar, us.address, us.phone,
         (SUM(aaa.vote_price)/COUNT(aaa.account_id)) vote_price,
         (SUM(aaa.vote_service)/COUNT(aaa.account_id)) vote_service,
         (SUM(aaa.vote_quality)/COUNT(aaa.account_id)) vote_quality,
         (SUM(aaa.vote_space)/COUNT(aaa.account_id)) vote_space,
         (SUM(aaa.vote_location)/COUNT(aaa.account_id)) vote_location,
         email, COUNT(aaa.account_id) num_comment');
		$this->db->from('account acc');
		$this->db->join('account_article_author aaa', 'acc.account_id=aaa.account_id', 'left');
		$this->db->join('user us', 'us.id=acc.user_id', 'left');

		$this->db->where(array('us.status' => '1', "role" => 2));
		$this->db->group_by('acc.account_id', 'DESC');
		$this->db->order_by('vote_price', 'DESC');
		if(strlen($area_id['area_id'])) {
			$this->db->where('acc.area_id', $area_id['area_id']);
		}
		if(strlen($area_id['account_name'])) {
			$this->db->like('acc.account_name', $area_id['account_name']);
		}
		$query = $this->db->get();
		return $query->result();
	}

}