<?php

class Bill extends Admin_Controller {
	private $model_name;

	function __construct() {
		parent::__construct();
		$this->model_name = "model";
		$this->load->model('admin_model', $this->model_name);
	}

	function index() {
		$params = array();
		if ($this->log_in_data->role == 2) {
			$params['account_id'] = $this->log_in_data->account_id;
		} else if ($this->log_in_data->role == 3) {
			$params['customer_id'] = $this->log_in_data->customer_id;
		} else if ($this->log_in_data->role == 1) {
			$params['admin_role'] = true;
		}
		$bills = $this->model->getListBill($params);
		$data = array(
			"header_title" => "Danh sách đơn hàng",
			"bills" => $bills
		);
		$this->output->append_title("Bill");
		$this->load->view("bills/index", $data);
	}

	public function detail($id = '') {
		if (intval($id) <= 0) {
			show_404();
		}
		$params = array(
			'bill_id' => $id
		);
		$bill = $this->model->getBillDetail($params);

		if (count($bill)) {
			$data = array(
				"header_title" => "Chi tiết đơn hàng",
				"bill" => $bill
			);
			$this->output->append_title("Bill | " . $bill[0]->name);
			$this->load->view("bills/detail", $data);
		} else {
			show_404();
		}

	}

	function delete($id) {
		if (intval($id) < 0) {
			show_404();
		}
		$ok = $this->model->deleteBill($id);
		if ($ok) {
			$smsg = "Đã xóa hóa đơn.";
			$this->session->set_flashdata("smsg", $smsg);
		} else {
			$serror = "Đã có lỗi khi xóa hóa đơn.";
			$this->session->set_flashdata("serror", $serror);
		}
		$this->session->set_flashdata("smsg", $smsg);
		redirect(site_url("admin/bill"));
	}

	function update($bill_id, $status) {
		if (!isset($bill_id) || !strlen(trim($bill_id)) || !isset($status) || (intval($status) > 4 || intval($status) < 1)) {
			redirect(site_url("admin/bill"));
		}

		$params = array();
		if ($this->log_in_data->role == 2) {
			$params['account_id'] = $this->log_in_data->account_id;
		} else if ($this->log_in_data->role == 3) {
			$params['customer_id'] = $this->log_in_data->customer_id;
		}
		$params['bill_id'] = $bill_id;

		$bill = $this->model->getListBill($params);

		if (count($bill)) {
			$params['status'] = $status;
			$ok = $this->model->updateBillStatus($params);
			if ($ok) {
				$this->session->set_flashdata("smsg", "Cập nhật hóa đơn thành công.");
			} else {
				$this->session->set_flashdata("smsg", "Cập nhật hóa đơn không thành công.");
			}
		}
		redirect(site_url("admin/bill"));
	}
}