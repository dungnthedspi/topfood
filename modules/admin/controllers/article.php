<?php

class Article extends Admin_Controller {
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
		$articles = $this->model->getListArticle($params);
		$data = array(
			"header_title" => "Danh sách bình luận",
			"articles" => $articles
		);
		$this->output->append_title("Article");
		$this->load->view("articles/index", $data);
	}

	public function detail($id = '') {
		if (intval($id) <= 0) {
			show_404();
		}
		$params = array(
			'article_id' => $id
		);
		$articles = $this->model->getArticleDetail($params);
		// debug($article);

		if (count($articles)) {
			$data = array(
				"header_title" => "Chi tiết bình luận",
				"articles" => $articles
			);
			$this->load->view("articles/detail", $data);
		} else {
			show_404();
		}

	}

	function delete($id) {
		if (intval($id) < 0) {
			show_404();
		}
		$ok = $this->model->deleteArticle($id);
		if ($ok) {
			$smsg = "Đã xóa bình luận.";
			$this->session->set_flashdata("smsg", $smsg);
		} else {
			$serror = "Đã có lỗi khi xóa bình luận.";
			$this->session->set_flashdata("serror", $serror);
		}
		$this->session->set_flashdata("smsg", $smsg);
		redirect(site_url("admin/article"));
	}

}