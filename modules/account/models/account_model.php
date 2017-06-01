<?php

class Account_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function getAccountProfile($id) {
		$this->db->select('acc.*, us.avatar, us.address, us.phone,
         (SUM(aaa.vote_price)/COUNT(aaa.account_id)) vote_price,
         (SUM(aaa.vote_service)/COUNT(aaa.account_id)) vote_service,
         (SUM(aaa.vote_quality)/COUNT(aaa.account_id)) vote_quality,
         (SUM(aaa.vote_space)/COUNT(aaa.account_id)) vote_space,
         (SUM(aaa.vote_location)/COUNT(aaa.account_id)) vote_location,
          email, COUNT(aaa.account_id) num_comment');
		$this->db->from('account_article_author aaa');
		$this->db->join('account acc', 'acc.account_id=aaa.account_id', 'right');
		$this->db->join('user us', 'us.id=acc.user_id', 'left');

		$this->db->where(array('us.status' => "1", 'acc.account_id' => $id));
		$this->db->group_by('acc.account_id', 'DESC');
		$this->db->order_by('vote_price', 'DESC');

		$this->db->trans_start();
		$query = $this->db->get();
		$this->db->trans_complete();

		if ($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function getAccountMenu($id, $item_id = null) {
		$where = array('acc.status' => "1", 'acc.account_id' => $id);
		if (isset($item_id)) {
			$where['item.item_id'] = $item_id;
		}
		$this->db->select("item.*");
		$this->db->from('item');
		$this->db->join('account_item ai', 'ai.item_id = item.item_id', 'left');
		$this->db->join('account acc', 'acc.account_id = ai.account_id', 'left');
		$this->db->where(
			$where
		);

		$this->db->trans_start();
		$query = $this->db->get();
		$this->db->trans_complete();

		return $query->result();

	}

	function getAccountArticle($id) {
		$this->db->select("art.*,vote_price, vote_service, vote_quality, vote_space, vote_location, 
		CONCAT(us.first_name,\" \",last_name) user_full_name, avatar, GROUP_CONCAT(path SEPARATOR ';') article_image");
		$this->db->from("account_article_author aaa");
		$this->db->join("account acc", "acc.account_id = aaa.account_id", "left");
		$this->db->join("article art", "art.article_id = aaa.article_id", "left");
		$this->db->join("article_photo art_p", "art.article_id = art_p.article_id", "left");
		$this->db->join("photo p", "p.photo_id = art_p.photo_id", "left");
		$this->db->join("customer cus", "cus.customer_id = aaa.author_id", "left");
		$this->db->join("user us", "us.id = cus.user_id", "left");

		$this->db->where(array('acc.status' => "1", 'acc.account_id' => $id));
		$this->db->group_by("`art`.`article_id`");
		$this->db->order_by("date_created", "DESC");

		$this->db->trans_start();
		$query = $this->db->get();
		$this->db->trans_complete();

		return $query->result();
	}

	function getAccountById($id, $item_id = null) {
		$where = array('acc.status' => "1", 'acc.account_id' => $id);
		$this->db->select("acc.*, us.avatar, us.address");
		$this->db->from('account acc');
		$this->db->join('user us', "us.id = acc.user_id", "left");
		$this->db->where(
			$where
		);

		$this->db->trans_start();
		$query = $this->db->get();
		$this->db->trans_complete();

		return $query->result();

	}

	function insertBill($params = array()) {

		$ok = false;
		$new_bill_ref = array(
			'account_id' => $params['account_id'],
			'customer_id' => $params['customer_id']
		);
		$bill_item = $params['bill_item'];

		unset($params['account_id'], $params['customer_id'], $params['bill_item']);

		$this->db->trans_start();

		$ok = $this->db->insert("bill", $params);
		$bill_id = $this->db->insert_id();
		if ($bill_id) {
			$new_bill_ref['bill_id'] = $bill_id;
		}
		$ok = $this->db->insert("account_bill_customer", $new_bill_ref);
		foreach ($bill_item as $k => $item) {
			$item['bill_id'] = $bill_id;
			$bill_item[$k] = $item;
		}
		$this->db->insert_batch("bill_item", $bill_item);

		$this->db->trans_complete();

		if ($ok) return $bill_id;

		return false;
	}
}