<?php

class Admin_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getList($params = array()) {
		$where = "WHERE status != 0";
		if (isset($params['role'])) {
			$where .= " AND role = " . $params['role'] . " ";
		}
		$sql = "SELECT * from user " . $where . " ORDER BY date_created DESC";

		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();

		return $query->result();
	}

	function getUserByRole($params = array()) {
		$where = "WHERE status != 0";
		if (count($params)) {
			$where .= " AND role IN (" . implode(",", $params) . ") ";
		}
		$sql = "SELECT * from user " . $where . " ORDER BY date_created";

		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();

		return $query->result();
	}

	public function getUserById($id) {
		$sql = "SELECT `user`.*, 
                acc.account_name, area.name, acc.account_id, acc.open_time, acc.close_time, acc.location, acc.shipping_fee,
                cus.gender 
                FROM `user` 
                LEFT JOIN account acc ON `user`.id=acc.user_id
                LEFT JOIN customer cus ON `user`.id=cus.user_id
                LEFT JOIN area ON area.area_id=acc.area_id
                WHERE `user`.id ='$id'";
		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();
		return $query->result();
	}

	public function updateUserById($id, $params = array()) {
		$accountData = array(
			'status' => $params['status']
		);

		if (isset($params['open_time'])) {
			$accountData['open_time'] = $params['open_time'];
			unset($params['open_time']);
		}
		if (isset($params['close_time'])) {
			$accountData['close_time'] = $params['close_time'];
			unset($params['close_time']);
		}
		if (isset($params['account_name'])) {
			$accountData['account_name'] = $params['account_name'];
			unset($params['account_name']);
		}
		if (isset($params['shipping_fee'])) {
			$accountData['shipping_fee'] = $params['shipping_fee'];
			unset($params['shipping_fee']);
		}
		if (isset($params['location'])) {
			$accountData['location'] = $params['location'];
			unset($params['location']);
		}
		$customerData = array();
		if (isset($params['gender'])) {
			$customerData['gender'] = $params['gender'];
			unset($params['gender']);
		}

		$ok = false;
		if (intval($id) >= 0) {
			$this->db->trans_start();

			$ok = $this->db->update('user', $params, array('id' => $id));
			if ($ok) {
				if ($params['role'] <= 2) {

					$exist_account_query = $this->db->get_where('account', array('user_id' => $id));
					$exist_account = $exist_account_query->result();
					if (count($exist_account)) {
						$ok = $this->db->update('account', $accountData, array('user_id' => $id));
					} else {
						$accountData['user_id'] = $id;
						$accountData['status'] = $params['status'];
						$accountData['account_name'] = ($accountData['account_name'] != '') ? $accountData['account_name'] : $params['first_name'] . " " . $params['last_name'];
						$ok = $this->db->insert('account', $accountData);
					}
				} else {
					$exist_account_query = $this->db->get_where('account', array('user_id' => $id));
					$exist_account = $exist_account_query->result();
					if ($exist_account) {
						$ok = $this->db->update('account', array('status' => '-1'), array('user_id' => $id));
					}
				}

				if (count($customerData)) {
					$ok = $this->db->update('customer', $customerData, array('user_id' => $id));
				}
			}
			$this->db->trans_complete();
		}

		return $ok;
	}

	public function deleteUserById($id) {
		$ok = false;
		if (intval($id) >= 0) {
			$this->db->trans_start();
			$user = $this->getUserById($id);
			$ok = $this->db->delete('user', array('id' => $id));
			if ($ok)
				switch ($user[0]->role) {
					case 1:
					case 2:
						$ok = $this->db->delete('account', array('user_id' => $id));
						if ($ok) {
							$ok = $this->db->delete('customer', array('user_id' => $id));
						}
						break;
					default:
						$ok = $this->db->delete('customer', array('user_id' => $id));
				}

			$this->db->trans_complete();
		}

		return $ok;
	}

	public function addUser($params = array()) {
		$this->db->trans_start();
		$new_user = array();
		$ok = false;
		$params['date_created'] = date("Y-m-d H:i:s");
		$ok = $this->db->insert('user', $params);
		if ($ok) {
			$new_user = $this->getUserByEmail($params['email']);
		}
		switch ($params['role']) {
			case 1:
			case 2:
				$account = array(
					'user_id' => $new_user[0]->id,
					'status' => 1,
					'account_name' => $params['first_name'] . " " . $params['last_name'],
					'date_created' => $params['date_created']
				);
				$ok2 = $this->db->insert('account', $account);
				if ($ok2) {
					$customer = array(
						'user_id' => $new_user[0]->id
					);
					$ok3 = $this->db->insert('customer', $customer);
				}
				$ok = ($ok2 && $ok3);
				break;
			default:
				$customer = array(
					'user_id' => $new_user[0]->id,
					'gender' => 0
				);
				$ok = $this->db->insert('customer', $customer);
		}
		$this->db->trans_complete();
		return $ok;
	}

	public function getUserByEmail($email) {
		if (trim($email) != '') {
			$this->db->trans_start();
			$query = $this->db->get_where(
				'user',
				array(
					'email' => $email
				)
			);
			$this->db->trans_complete();
			return $query->result();
		}
	}

	public function getUserByName($username) {
		if (trim($username) != '') {
			$this->db->trans_start();
			$query = $this->db->get_where(
				'user',
				array(
					'username' => $username
				)
			);
			$this->db->trans_complete();
			return $query->result();
		}
	}

	function getListArticle($params = array()) {
		$where = ' WHERE article.status !=0 ';
		if (isset($params['account_id']) && $params['account_id'] != '') {
			$where .= " AND aaa.account_id = '" . $params['account_id'] . "' ";
		}elseif (isset($params['customer_id']) && $params['customer_id'] != '') {
			$where .= " AND aaa.author_id = '" . $params['customer_id'] . "' ";
		}
		if(isset($params['admin_role']) && $params['admin_role'] ==1){
			$where = ' WHERE article.status !=0 ';
		}

		$sql = "SELECT article.*, acc.account_name, 
                CONCAT(user.first_name,\" \",user.last_name) customer_name,
                (SUM(aaa.vote_price)/COUNT(aaa.account_id)) vote_price,
         		(SUM(aaa.vote_service)/COUNT(aaa.account_id)) vote_service,
         		(SUM(aaa.vote_quality)/COUNT(aaa.account_id)) vote_quality,
         		(SUM(aaa.vote_space)/COUNT(aaa.account_id)) vote_space,
         		(SUM(aaa.vote_location)/COUNT(aaa.account_id)) vote_location
        FROM article 
        LEFT JOIN account_article_author aaa ON article.article_id = aaa.article_id
        LEFT JOIN account acc ON aaa.account_id = acc.account_id
        LEFT JOIN customer cus ON aaa.author_id = cus.customer_id
        LEFT JOIN user ON user.id = cus.user_id
        LEFT JOIN user u_acc ON u_acc.id = acc.user_id" . 
			$where .
			"GROUP BY article.article_id ORDER BY article.date_created DESC";
		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();
		return $query->result();
	}

	function getArticleDetail($params = array()) {
		$where = ' WHERE article.status !=0 AND article.article_id=' . $params['article_id'];

		$sql = "SELECT article.*, acc.account_name, CONCAT(u_acc.first_name,' ',u_acc.last_name) account_base_name, 
                CONCAT(u_cus.first_name,\" \",u_cus.last_name) customer_name, u_cus.avatar,
                (SUM(aaa.vote_price)/COUNT(aaa.account_id)) vote_price,
         		(SUM(aaa.vote_service)/COUNT(aaa.account_id)) vote_service,
         		(SUM(aaa.vote_quality)/COUNT(aaa.account_id)) vote_quality,
         		(SUM(aaa.vote_space)/COUNT(aaa.account_id)) vote_space,
         		(SUM(aaa.vote_location)/COUNT(aaa.account_id)) vote_location,
         		GROUP_CONCAT(path SEPARATOR ';') article_image
            FROM article 
            LEFT JOIN account_article_author aaa ON article.article_id = aaa.article_id
            LEFT JOIN account acc ON aaa.account_id = acc.account_id
            LEFT JOIN customer cus ON aaa.author_id = cus.customer_id
            LEFT JOIN `user` u_cus ON u_cus.id = cus.user_id
            LEFT JOIN `user` u_acc ON u_acc.id = acc.user_id
            LEFT JOIN  article_photo art_p ON art_p.article_id = article.article_id
            LEFT JOIN  photo p ON p.photo_id = art_p.photo_id" .
			$where;

		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();
		return $query->result();
	}

	function getListBill($params = array()) {
		$where = ' WHERE bill.status !=0 ';
		if (isset($params['account_id']) && $params['account_id'] != '') {
			$where .= " AND abc.account_id = '" . $params['account_id'] . "' ";
		}elseif (isset($params['customer_id']) && $params['customer_id'] != '') {
			$where .= " AND abc.customer_id = '" . $params['customer_id'] . "' ";
		}
		if(isset($params['admin_role']) && $params['admin_role'] ==1){
			$where = ' WHERE bill.status !=0 ';
		}

		$sql = "SELECT bill.*, acc.account_name, CONCAT(u_acc.first_name,' ',u_acc.last_name) account_base_name, 
                CONCAT(user.first_name,\" \",user.last_name) customer_name, SUM(item.price * bi.quantity) as total_price
        FROM bill 
        LEFT JOIN account_bill_customer abc ON bill.bill_id = abc.bill_id
        LEFT JOIN account acc ON abc.account_id = acc.account_id
        LEFT JOIN customer cus ON abc.customer_id = cus.customer_id
        LEFT JOIN user ON user.id = cus.user_id
        LEFT JOIN user u_acc ON u_acc.id = acc.user_id
        LEFT JOIN bill_item bi ON bill.bill_id = bi.bill_id 
        LEFT JOIN item ON item.item_id = bi.item_id" .
			$where .
			"GROUP BY bill.bill_id ORDER BY bill.date_created DESC";
		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();
		return $query->result();
	}

	function getBillDetail($params = array()) {
		$where = ' WHERE bill.status !=0 AND bill.bill_id=' . $params['bill_id'];

		$sql = "SELECT bill.*,
            bi.quantity, item.price, item.photo,item.item_id, item.`name` item_name,
            u_acc.phone account_phone, acc.account_name,
            cus.customer_id
            FROM bill 
            LEFT JOIN account_bill_customer abc ON bill.bill_id = abc.bill_id
            LEFT JOIN account acc ON abc.account_id = acc.account_id
            LEFT JOIN customer cus ON abc.customer_id = cus.customer_id
            LEFT JOIN `user` u_cus ON u_cus.id = cus.user_id
            LEFT JOIN `user` u_acc ON u_acc.id = acc.user_id
            LEFT JOIN bill_item bi ON bill.bill_id = bi.bill_id 
            LEFT JOIN  item ON item.item_id = bi.item_id " .
			$where . "
            ORDER BY bi.quantity DESC";

		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();
		return $query->result();
	}

	function updateBillStatus($params = array()) {
		$this->db->trans_start();
		$ok = $this->db->update("bill", array('status' => $params['status']), array('bill_id' => $params['bill_id']));
		$this->db->trans_complete();
		return $ok;
	}

	function getListAccountMenu($accountId, $userRole) {
		$where = " WHERE ai.account_id = " . $accountId;
		if($userRole ==1){
			$where='';
		}
		$sql = 'SELECT item.* , acc.account_name
            FROM `item`
            LEFT JOIN account_item ai ON ai.item_id = item.item_id
            LEFT JOIN account acc ON acc.account_id = ai.account_id
            ' . $where.' ORDER BY item.date_created DESC';

		$this->db->trans_start();
		$query = $this->db->query($sql);
		$this->db->trans_complete();
		return $query->result();
	}

	function insertBatch($data, $table_name) {
		$ok = false;
		$this->db->trans_start();
		$ok = $this->db->insert_batch($table_name, $data);
		$this->db->trans_complete();
		return $ok;
	}

	function deleteItem($id) {
		$ok = false;
		$this->db->trans_start();
		$ok = $this->db->delete('item', array('item_id' => $id));
		$ok = $this->db->delete('account_item', array('item_id' => $id));
		$this->db->trans_complete();
		return $ok;
	}

	function deleteBill($id) {
		$ok = null;
		$this->db->trans_start();
		$ok = $this->db->delete('bill', array('bill_id' => $id));
		$ok = $this->db->delete('bill_item', array('bill_id' => $id));
		$ok = $this->db->delete('account_bill_customer', array('bill_id' => $id));
		$this->db->trans_complete();
		return $ok;
	}

	function deleteArticle($id) {
		$ok = null;
		$this->db->trans_start();
		$ok = $this->db->delete('article', array('article_id' => $id));
		$ok = $this->db->delete('article_photo', array('article_id' => $id));
		$ok = $this->db->delete('account_article_author', array('article_id' => $id));
		$this->db->trans_complete();
		return $ok;
	}

	function getMenuItemById($id) {
		$this->db->trans_start();
		$query = $this->db->get_where('item', array('item_id' => $id));
		$this->db->trans_complete();
		return $query->result();
	}

	function updateMenuItemById($id, $params) {
		$this->db->trans_start();
		$ok = $this->db->update('item', $params, array('item_id' => $id));
		$this->db->trans_complete();
		return $ok;
	}
}