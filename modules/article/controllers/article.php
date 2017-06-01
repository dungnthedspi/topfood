<?php

class Article extends MY_Controller {
	private $model_name;

	function __construct() {
		parent::__construct();
		$this->model_name = "model";
		$this->load->model('article_model', $this->model_name);
	}

	function post() {
		$post = $this->input->post();
//		debug($_FILES, false);
		if (!$this->logged_in()) {
			redirect(site_url("auth"));
		}
		if (!$post['submit']) {
			redirect($_SERVER['HTTP_REFERER']);
		}
		$multi_upload=null;
		if(count($_FILES['image'])) {
			$multi_upload = do_multi_upload("image");
		}
		$ok = null;
		$post['status'] = 1;
		if($multi_upload["ok"]){
			$new_article_data = array(
				'title' => $post['title'],
				'description' => $post['description'],
				'status' => $post['status'],
				'vote_price' => $post['vote_price'],
				'vote_service' => $post['vote_service'],
				'vote_quality' => $post['vote_quality'],
				'vote_space' => $post['vote_space'],
				'vote_location' => $post['vote_location'],
				'account_id' => $post['account_id'],
				'author_id' => $this->_login_data->customer_id,
				'date_created' => date("Y-m-d H:i:s"),
				'photos' => $multi_upload['new_file']
			);
			$ok = $this->model->insertPost($new_article_data);
		}

		if ($ok) {
			$this->session->flashdata("smsg", "Cảm ơn bài đánh giá của bạn!");
		} else {
			$this->session->flashdata("serror", "Vui lòng thử lại sau!");
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}