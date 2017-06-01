<?php

class Account extends MY_Controller {
	private $model_name;

	function __construct() {
		parent::__construct();
		$this->model_name = "model";
		$this->load->model('account_model', $this->model_name);
	}

	function index($id = null) {
		if (!isset($id) || intval($id) < 0) {
			show_404();
		}
		$current_cart_id = $this->session->userdata("current_cart_id");
		if ($current_cart_id != $id) {
			$current_cart_id = $id;
			$this->session->set_userdata("current_cart_id", $current_cart_id);
			$this->session->set_userdata("cart", null);
		}
//        $this->session->set_userdata("cart",null);
		$account = $this->model->getAccountProfile($id);
//        debug($this->db->last_query());
		if (!$account) {
			show_404();
		}
		$account_menus = $this->model->getAccountMenu($id);
		$account_articles = $this->model->getAccountArticle($id);
//		if(!$account_articles[0]->article_id) unset($account_articles[0]);
		$data = array(
			'account' => $account[0],
			'menus' => $account_menus,
			'articles' => $account_articles,
		);
		$this->load->js("assets/themes/default/js/star_rate.js");
		$this->load->view("index", $data);
	}

	function add_to_cart($account_id, $item_id) {
		if (!isset($account_id) || !isset($item_id) || trim($item_id) == '') {
			show_404();
		}

		$current_cart = $this->session->userdata("cart");
		$update_cart = false;
		if (is_array($current_cart)) {
			if ($current_cart[$item_id]) {
//update to current cart
				$current_cart[$item_id]['quantity']++;
				$update_cart = true;

			} else {
//insert to current cart
				$item_data = $this->model->getAccountMenu($account_id, $item_id);
				if (count($item_data)) {
					$item_data = $item_data[0];
					$current_cart[$item_id] = array(
						'quantity' => 1,
						'name' => $item_data->name,
						'price' => $item_data->price,
						'item_id' => $item_data->item_id
					);
					$update_cart = true;
				}
			}
		} else {
//create new cart
			$item_data = $this->model->getAccountMenu($account_id, $item_id);
			if (count($item_data)) {
				$item_data = $item_data[0];
				$current_cart = array(
					$item_id => array(
						'quantity' => 1,
						'name' => $item_data->name,
						'price' => $item_data->price,
						'item_id' => $item_data->item_id
					)
				);
				$update_cart = true;

			}
		}
		if ($update_cart) {
			$this->session->set_userdata("cart", $current_cart);
		}
		redirect(site_url("account/" . $account_id . "#menu"));
	}

	function reduce_cart($account_id, $item_id) {
		if (!isset($account_id) || !isset($item_id) || trim($item_id) == '') {
			show_404();
		}

		$current_cart = $this->session->userdata("cart");

		if (is_array($current_cart)) {
			if ($current_cart[$item_id]) {
//update to current cart

				if ($current_cart[$item_id]['quantity'] > 1) {
					$current_cart[$item_id]['quantity']--;
				} else {
					unset($current_cart[$item_id]);
				}
				$this->session->set_userdata("cart", $current_cart);
			}
		}

		redirect(site_url("account/" . $account_id . "#menu"));
	}

	function detele_from_cart($account_id, $item_id) {
		if (!isset($account_id) || !isset($item_id) || trim($item_id) == '') {
			show_404();
		}

		$current_cart = $this->session->userdata("cart");

		if (is_array($current_cart)) {
			if ($current_cart[$item_id]) {
//update to current cart
				unset($current_cart[$item_id]);
				$this->session->set_userdata("cart", $current_cart);
			}
		}

		redirect(site_url("account/" . $account_id . "#menu"));
	}

	function reset_cart($account_id) {
		$this->session->set_userdata("current_cart_id", $account_id);
		$this->session->set_userdata("cart", null);
		redirect(site_url("account/" . $account_id . "#menu"));
	}

	function checkout_cart($account_id) {
		$this->load->css("assets/themes/default/css/bootstrap-datetimepicker.min.css");
		$this->load->js("assets/themes/default/js/validator.min.js");
		$this->load->js("assets/themes/default/js/bootstrap-datetimepicker.min.js");
		$current_cart_id = $this->session->userdata("current_cart_id", $account_id);
		if ($current_cart_id == $account_id) {
			$cart = $this->session->userdata("cart", null);

			$data = array(
				"cart" => $cart
			);

			$restaurant = $this->model->getAccountById($account_id);
			if (count($restaurant)) {
				$restaurant = $restaurant[0];
				$data['restaurant'] = $restaurant;
			}
			$this->load->view("checkout", $data);
		} else {
			redirect(site_url("account/" . $account_id));
		}
	}

	function finish_cart() {
//        debug($this->input->post());
		$post = $this->input->post();
		if (!isset($post['submit'])) {
			redirect($_SERVER['HTTP_REFERER']);
		}
		$current_cart = $this->session->userdata("cart");

		$current_item = array();
		if (count($current_cart)) {
			foreach ($current_cart as $k => $v) {
				$current_item[] = array(
					'quantity' => $v['quantity'],
					'item_id' => $v['item_id']
				);
			}
		}
		$new_bill_data = array(
			"name" => uniqid("bill"),
			"account_id" => $post['account_id'],
			"account_address" => $post['account_address'],
			"customer_id" => ((isset($this->_login_data->customer_id)) ? $this->_login_data->customer_id : ''),
			"customer_address" => $post['destination'],
			"customer_name" => $post['full_name'],
			"customer_phone" => $post['phone'],
			"customer_email" => $post['email'],
			"shipping_fee" => $post['shipping_fee'],
			"status" => 1,
			"date_created" => date("Y-m-d H:i:s"),
			"date_close" => date("Y-m-d H:i:s", strtotime($post['order_date_time'])),
			'bill_item' => $current_item
		);

		$bill_id = $this->model->insertBill($new_bill_data);
		if ($bill_id) {
			$this->session->set_userdata("cart", null);
			$this->session->set_flashdata("smsg", "Đơn hàng " . $new_bill_data['name'] . " đã được gửi đến nhà hàng.");
		} else {
			$this->session->set_flashdata("serror", "Có lỗi trong quá trình tạo đơn hàng, vui lòng thử lại.");
		}
		redirect(site_url("account/" . $this->session->userdata("current_cart_id")));
	}

}